<?php

use App\Mail\VerifyAccountEmail;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Mailer\Exception\TransportException;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    Mail::fake();

    $response = $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $user = User::where('email', 'test@example.com')->firstOrFail();

    $this->assertAuthenticatedAs($user);
    expect($user->hasVerifiedEmail())->toBeFalse();
    Mail::assertSent(VerifyAccountEmail::class, fn ($mail) => $mail->hasTo($user->email)
        && str_contains($mail->render(), 'Confirma tu correo')
        && URL::hasValidSignature(Request::create($mail->verificationUrl))
    );
    $response->assertRedirect(route('verification.notice'));
});

test('registration succeeds when the verification email cannot be sent', function () {
    Mail::fake();

    Event::listen(Registered::class, function (Registered $event): void {
        throw new TransportException('SMTP unavailable');
    });

    $response = $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $user = User::where('email', 'test@example.com')->firstOrFail();

    $this->assertAuthenticatedAs($user);
    expect($user->hasVerifiedEmail())->toBeFalse();
    $response->assertRedirect(route('verification.notice'))
        ->assertSessionHas('status', 'verification-link-failed');
});
