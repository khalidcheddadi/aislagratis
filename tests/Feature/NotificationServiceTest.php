<?php

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Str;

test('marking a user notification as read returns its update status', function () {
    $user = User::factory()->create();
    $notification = $user->notifications()->create([
        'id' => (string) Str::uuid(),
        'type' => 'test.notification',
        'data' => ['message' => 'Test notification'],
    ]);
    $service = app(NotificationService::class);

    expect($service->markAsRead($user, $notification->id))->toBeTrue()
        ->and($notification->fresh()->read_at)->not->toBeNull()
        ->and($service->markAsRead($user, (string) Str::uuid()))->toBeFalse();
});
