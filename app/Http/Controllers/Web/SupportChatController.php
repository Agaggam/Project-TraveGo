<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportChatController extends Controller
{
    /**
     * Get user's conversations
     */
    public function index(): JsonResponse
    {
        $conversations = SupportConversation::where('user_id', Auth::id())
            ->with('latestMessage')
            ->orderBy('last_message_at', 'desc')
            ->get()
            ->map(function ($conv) {
                return [
                    'id' => $conv->id,
                    'subject' => $conv->subject,
                    'status' => $conv->status,
                    'unread_count' => $conv->unreadCountFor('user'),
                    'last_message' => $conv->latestMessage?->message,
                    'last_message_at' => $conv->last_message_at?->diffForHumans(),
                    'created_at' => $conv->created_at->format('d M Y'),
                ];
            });

        return response()->json([
            'success' => true,
            'conversations' => $conversations,
        ]);
    }

    /**
     * Start a new conversation
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Check if user has an open conversation
        $existingConversation = SupportConversation::where('user_id', Auth::id())
            ->open()
            ->first();

        if ($existingConversation) {
            // Add message to existing conversation
            $message = SupportMessage::create([
                'conversation_id' => $existingConversation->id,
                'sender_type' => 'user',
                'sender_id' => Auth::id(),
                'message' => $request->message,
            ]);

            $existingConversation->update(['last_message_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan terkirim',
                'conversation_id' => $existingConversation->id,
                'data' => $this->formatMessage($message),
            ]);
        }

        // Create new conversation
        $conversation = SupportConversation::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject ?? 'Bantuan Umum',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        // Create first message
        $message = SupportMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'user',
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Conversation dimulai',
            'conversation_id' => $conversation->id,
            'data' => $this->formatMessage($message),
        ], 201);
    }

    /**
     * Get conversation messages
     */
    public function show(SupportConversation $conversation): JsonResponse
    {
        // Check ownership
        if ($conversation->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Mark admin messages as read
        $conversation->messages()
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()
            ->with('sender:id,name')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => $this->formatMessage($m));

        return response()->json([
            'success' => true,
            'conversation' => [
                'id' => $conversation->id,
                'subject' => $conversation->subject,
                'status' => $conversation->status,
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Send a message
     */
    public function sendMessage(Request $request, SupportConversation $conversation): JsonResponse
    {
        // Check ownership
        if ($conversation->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Check if conversation is open
        if (!$conversation->isOpen()) {
            return response()->json([
                'success' => false, 
                'message' => 'Conversation sudah ditutup'
            ], 400);
        }

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $message = SupportMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'user',
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'data' => $this->formatMessage($message),
        ]);
    }

    /**
     * Get new messages (polling endpoint)
     */
    public function getMessages(Request $request, SupportConversation $conversation): JsonResponse
    {
        // Check ownership
        if ($conversation->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $lastId = $request->query('last_id', 0);

        // Mark admin messages as read
        $conversation->messages()
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()
            ->where('id', '>', $lastId)
            ->with('sender:id,name')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => $this->formatMessage($m));

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'status' => $conversation->status,
        ]);
    }

    /**
     * Get active conversation for current user
     */
    public function getActiveConversation(): JsonResponse
    {
        $conversation = SupportConversation::where('user_id', Auth::id())
            ->open()
            ->first();

        if (!$conversation) {
            return response()->json([
                'success' => true,
                'has_active' => false,
            ]);
        }

        // Mark admin messages as read
        $conversation->messages()
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()
            ->with('sender:id,name')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => $this->formatMessage($m));

        return response()->json([
            'success' => true,
            'has_active' => true,
            'conversation' => [
                'id' => $conversation->id,
                'subject' => $conversation->subject,
                'status' => $conversation->status,
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Format message for response
     */
    private function formatMessage(SupportMessage $message): array
    {
        return [
            'id' => $message->id,
            'sender_type' => $message->sender_type,
            'sender_name' => $message->sender_type === 'admin' ? 'Admin Support' : $message->sender?->name,
            'message' => $message->message,
            'is_read' => $message->is_read,
            'created_at' => $message->created_at->format('H:i'),
            'created_date' => $message->created_at->format('d M Y'),
        ];
    }
}
