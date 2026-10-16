<?php

use App\Mail\VerifyAccountEmail;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('api registration requires email verification before issuing a token', function () {
    Mail::fake();

    $response = $this->postJson('/api/v1/auth/register', [
        'first_name' => 'API',
        'last_name' => 'Customer',
        'email' => 'api-customer@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'device_name' => 'mobile',
    ]);

    $user = User::where('email', 'api-customer@example.com')->firstOrFail();

    $response->assertCreated()
        ->assertJsonPath('email_verification_required', true)
        ->assertJsonPath('verification_email_sent', true);

    expect($response->json('token'))->toBeNull()
        ->and($user->hasVerifiedEmail())->toBeFalse();

    Mail::assertSent(VerifyAccountEmail::class, fn ($mail) => $mail->hasTo($user->email));
});

test('api login rejects users whose email is not verified', function () {
    $user = User::factory()->unverified()->create();

    $this->postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'password',
        'device_name' => 'mobile',
    ])->assertForbidden();

    expect($user->tokens()->count())->toBe(0);
});

test('api resend response does not reveal whether an email exists', function () {
    $user = User::factory()->unverified()->create();
    Mail::fake();

    $knownEmailResponse = $this->postJson('/api/v1/auth/verification-notification', [
        'email' => $user->email,
    ])->assertAccepted();

    $unknownEmailResponse = $this->postJson('/api/v1/auth/verification-notification', [
        'email' => 'unknown@example.com',
    ])->assertAccepted();

    expect($knownEmailResponse->json('message'))
        ->toBe($unknownEmailResponse->json('message'));

    Mail::assertSent(VerifyAccountEmail::class, fn ($mail) => $mail->hasTo($user->email));
});

test('sanctum api routes reject unverified users', function () {
    $user = User::factory()->unverified()->create();
    $token = $user->createToken('mobile')->plainTextToken;

    $this->withToken($token)
        ->getJson('/api/v1/auth/me')
        ->assertForbidden();
});
