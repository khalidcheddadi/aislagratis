<?php

use App\Enums\UserRole;
use App\Models\CookieConsent;
use App\Models\Lead;
use App\Models\User;
use Database\Seeders\CoverageAreaSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\ActivityLogStatus;

function validStudySubmission(array $overrides = []): array
{
    return array_merge([
        'first_name' => 'Lucia',
        'last_name' => 'Garcia',
        'email' => 'lucia@example.com',
        'phone' => '+34 600 111 222',
        'postal_code' => '28001',
        'address' => 'Calle Mayor 10',
        'city' => 'Madrid',
        'property_type' => 'casa_unifamiliar',
        'eligibility_owner' => 'Sí',
        'eligibility_property_kind' => 'unifamiliar',
        'eligibility_zone' => 'Desván o buhardilla no habitable',
        'eligibility_access' => 'Escalera fija',
        'eligibility_habitable' => 'No, es un espacio no habitable',
        'eligibility_age' => 'Más de 20 años',
        'eligibility_aid' => 'No',
        'eligibility_contact_preference' => 'Sí, prefiero WhatsApp',
        'cadastral_reference' => '1234567AB1234C0001DE',
        'message' => 'Quiero mejorar el aislamiento de mi vivienda.',
        'privacy' => '1',
    ], $overrides);
}

test('study submissions persist structured eligibility and privacy data for admin review', function () {
    $this->seed(CoverageAreaSeeder::class);
    Cache::forget('coverage.28001');
    app(ActivityLogStatus::class)->disable();

    $response = $this->post(route('leads.store'), validStudySubmission());

    $response->assertRedirect(route('leads.thanks'));
    $lead = Lead::query()->where('email', 'lucia@example.com')->firstOrFail();

    expect($lead->is_owner)->toBeTrue()
        ->and($lead->eligibility_property_kind)->toBe('unifamiliar')
        ->and($lead->eligibility_zone)->toBe('Desván o buhardilla no habitable')
        ->and($lead->eligibility_access)->toBe('Escalera fija')
        ->and($lead->eligibility_habitable)->toBe('No, es un espacio no habitable')
        ->and($lead->eligibility_age)->toBe('Más de 20 años')
        ->and($lead->eligibility_prior_aid)->toBe('No')
        ->and($lead->contact_preference)->toBe('Sí, prefiero WhatsApp')
        ->and($lead->cadastral_reference)->toBe('1234567AB1234C0001DE')
        ->and($lead->message)->toBe('Quiero mejorar el aislamiento de mi vivienda.')
        ->and($lead->privacy_accepted_at)->not->toBeNull();

    $this->seed(RolesAndPermissionsSeeder::class);
    $admin = User::factory()->admin()->create();
    $admin->assignRole(UserRole::ADMIN->value);

    $this->actingAs($admin)
        ->get(route('admin.leads.show', $lead))
        ->assertOk()
        ->assertSee('Respuestas del estudio CAE')
        ->assertSee('Lucia')
        ->assertSee('Escalera fija')
        ->assertSee('1234567AB1234C0001DE')
        ->assertSee('Privacidad aceptada');
});

test('study submissions require the eligibility answers shown in the questionnaire', function () {
    $response = $this->from(route('leads.create'))
        ->post(route('leads.store'), validStudySubmission(['eligibility_age' => 'invalid']));

    $response->assertRedirect(route('leads.create'))
        ->assertSessionHasErrors('eligibility_age');
    expect(Lead::query()->count())->toBe(0);
});

test('study submission writes its activity log using the installed package schema', function () {
    $this->post(route('leads.store'), validStudySubmission())
        ->assertRedirect(route('leads.thanks'));

    $lead = Lead::query()->where('email', 'lucia@example.com')->firstOrFail();

    $this->assertDatabaseHas('activity_log', [
        'subject_type' => Lead::class,
        'subject_id' => $lead->id,
        'event' => 'created',
    ]);

    expect(Schema::hasColumn('activity_log', 'batch_uuid'))->toBeTrue();
});

test('admin can download a valid Excel workbook with all study answers', function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    app(ActivityLogStatus::class)->disable();

    $lead = Lead::factory()->create([
        'eligibility_zone' => 'Desván o buhardilla no habitable',
        'eligibility_prior_aid' => 'No',
        'contact_preference' => 'Sí, prefiero WhatsApp',
        'privacy_accepted_at' => now(),
    ]);
    $admin = User::factory()->admin()->create();
    $admin->assignRole(UserRole::ADMIN->value);

    $response = $this->actingAs($admin)->get(route('admin.leads.export', $lead));

    $response->assertOk()
        ->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
        ->assertHeader('content-disposition', 'attachment; filename=solicitud-'.$lead->id.'.xlsx');

    $contents = $response->streamedContent();
    expect(substr($contents, 0, 2))->toBe('PK');

    $path = tempnam(sys_get_temp_dir(), 'test-lead-xlsx-');
    expect($path)->not->toBeFalse();
    file_put_contents($path, $contents);

    $archive = new ZipArchive;
    expect($archive->open($path))->toBeTrue();
    $sheet = $archive->getFromName('xl/worksheets/sheet1.xml');
    $archive->close();
    unlink($path);

    expect($sheet)->toContain('Desván o buhardilla no habitable')
        ->toContain('Sí, prefiero WhatsApp')
        ->toContain('Privacidad aceptada');
});

test('cookie consent choices are stored, updated, and visible to administrators only', function () {
    $token = 'visitor-token-123456';

    $this->postJson(route('cookie.consent'), [
        'consent' => 'accepted',
        'visitor_token' => $token,
    ])->assertOk()->assertJson(['success' => true]);

    $this->assertDatabaseHas('cookie_consents', [
        'visitor_token' => $token,
        'consent_value' => 'accepted',
        'user_agent' => 'Symfony',
    ]);

    $this->postJson(route('cookie.consent'), [
        'consent' => 'rejected',
        'visitor_token' => $token,
    ])->assertOk()->assertJson(['success' => true]);

    expect(CookieConsent::query()->where('visitor_token', $token)->count())->toBe(1);
    $this->assertDatabaseHas('cookie_consents', [
        'visitor_token' => $token,
        'consent_value' => 'rejected',
    ]);

    $this->seed(RolesAndPermissionsSeeder::class);
    $admin = User::factory()->admin()->create();
    $admin->assignRole(UserRole::ADMIN->value);

    $this->actingAs($admin)
        ->get(route('admin.cookie-consents.index'))
        ->assertOk()
        ->assertSee('Consentimientos de cookies')
        ->assertSee('Rechazadas')
        ->assertSee(substr($token, 0, 8));

    $sales = User::factory()->sales()->create();
    $sales->assignRole(UserRole::SALES->value);
    $this->actingAs($sales)
        ->get(route('admin.cookie-consents.index'))
        ->assertForbidden();
});
