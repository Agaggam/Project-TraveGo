<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    protected ChatbotService $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * Handle chat message
     */
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $result = $this->chatbotService->processMessage($request->message);

        return response()->json($result);
    }

    /**
     * Get chat history
     */
    public function history(): JsonResponse
    {
        $history = $this->chatbotService->getHistory();

        return response()->json([
            'success' => true,
            'history' => $history,
        ]);
    }

    /**
     * Clear chat history
     */
    public function clearHistory(): JsonResponse
    {
        $cleared = $this->chatbotService->clearHistory();

        return response()->json([
            'success' => $cleared,
            'message' => $cleared ? 'History berhasil dihapus' : 'Gagal menghapus history',
        ]);
    }
}
