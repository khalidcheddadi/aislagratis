<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $service) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'notifications' => $this->service->forUser($request->user(), 50),
            'unread_count' => $this->service->unreadCount($request->user()),
        ]);
    }

    public function markAsRead(Request $request, string $id): JsonResponse
    {
        $success = $this->service->markAsRead($request->user(), $id);

        return response()->json(['success' => $success]);
    }

    public function markAllAsRead(Request $request): JsonResponse
    {
        $count = $this->service->markAllAsRead($request->user());

        return response()->json(['marked' => $count]);
    }
}
