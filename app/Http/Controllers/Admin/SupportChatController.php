<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SupportChatController extends Controller
{
    /**
     * Display list of all conversations
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        
        $query = SupportConversation::with(['user:id,name,email', 'latestMessage'])
            ->orderBy('last_message_at', 'desc');

        if ($status === 'open') {
            $query->open();
        } elseif ($status === 'closed') {
            $query->closed();
        }

        $conversations = $query->paginate(20);

        // Add unread count for admin
        $conversations->getCollection()->transform(function ($conv) {
            $conv->unread_count = $conv->unreadCountFor('admin');
            return $conv;
        });

        // Stats
        $stats = [
            'total' => SupportConversation::count(),
            'open' => SupportConversation::open()->count(),
            'closed' => SupportConversation::closed()->count(),
            'unread' => SupportMessage::fromUser()->unread()->count(),
        ];

        return view('admin.support-chat.index', compact('conversations', 'stats', 'status'));
    }

    /**
     * Show specific conversation
     */
    public function show(SupportConversation $conversation): View
    {
        // Mark user messages as read
        $conversation->messages()
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()
            ->with('sender:id,name')
            ->orderBy('created_at', 'asc')
            ->get();

        $conversation->load('user:id,name,email');

        return view('admin.support-chat.show', compact('conversation', 'messages'));
    }

    /**
     * Send reply message
     */
    public function sendMessage(Request $request, SupportConversation $conversation): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Reopen if closed
        if (!$conversation->isOpen()) {
            $conversation->reopen();
        }

        $message = SupportMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'admin',
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $message->id,
                'sender_type' => 'admin',
                'sender_name' => 'Admin Support',
                'message' => $message->message,
                'created_at' => $message->created_at->format('H:i'),
            ],
        ]);
    }

    /**
     * Get new messages (polling)
     */
    public function getMessages(Request $request, SupportConversation $conversation): JsonResponse
    {
        $lastId = $request->query('last_id', 0);

        // Mark user messages as read
        $conversation->messages()
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()
            ->where('id', '>', $lastId)
            ->with('sender:id,name')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'sender_type' => $m->sender_type,
                    'sender_name' => $m->sender_type === 'admin' ? 'Admin Support' : $m->sender?->name,
                    'message' => $m->message,
                    'created_at' => $m->created_at->format('H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    /**
     * Close conversation
     */
    public function closeConversation(SupportConversation $conversation): JsonResponse
    {
        $conversation->close();

        return response()->json([
            'success' => true,
            'message' => 'Conversation ditutup',
        ]);
    }

    /**
     * Reopen conversation
     */
    public function reopenConversation(SupportConversation $conversation): JsonResponse
    {
        $conversation->reopen();

        return response()->json([
            'success' => true,
            'message' => 'Conversation dibuka kembali',
        ]);
    }

    /**
     * Get unread count for admin navbar
     */
    public function getUnreadCount(): JsonResponse
    {
        $count = SupportMessage::fromUser()->unread()->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }
    /**
     * Delete conversation
     */
    public function destroy(SupportConversation $conversation): \Illuminate\Http\RedirectResponse
    {
        $conversation->messages()->delete();
        $conversation->delete();

        return redirect()->route('admin.support-chat.index')
            ->with('success', 'Conversation berhasil dihapus');
    }
}
