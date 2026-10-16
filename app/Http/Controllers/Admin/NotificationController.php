<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $service) {}

    public function index(Request $request): View
    {
        $notifications = $this->service->forUser($request->user(), 50);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, string $notification)
    {
        $this->service->markAsRead($request->user(), $notification);

        return back();
    }

    public function markAllAsRead(Request $request)
    {
        $count = $this->service->markAllAsRead($request->user());

        return back()->with('success', "{$count} notificaciones marcadas como leídas.");
    }
}
