<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    expect($response->headers->get('Cache-Control'))->toContain('no-store');
});

test('users are redirected to the correct dashboard after authentication', function (UserRole $role, string $dashboardRoute) {
    $user = User::factory()->create(['role' => $role]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route($dashboardRoute));
})->with([
    'admin' => [UserRole::ADMIN, 'admin.dashboard'],
    'sales' => [UserRole::SALES, 'admin.dashboard'],
    'technician' => [UserRole::TECHNICIAN, 'admin.appointments.index'],
    'customer' => [UserRole::CUSTOMER, 'customer.dashboard'],
]);

test('expired login and registration sessions return to a fresh form', function (string $path) {
    $request = Request::create('/'.$path, 'POST');
    $response = app(ExceptionHandler::class)->render($request, new TokenMismatchException);

    expect($response->getStatusCode())->toBe(302)
        ->and($response->headers->get('Location'))->toBe(route($path, ['session_expired' => 1]));

    $this->get('/'.$path.'?session_expired=1')
        ->assertOk()
        ->assertSee('El formulario se ha actualizado');
})->with([
    'login' => 'login',
    'register' => 'register',
]);

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
