<?php

use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\Installation;
use App\Models\Lead;
use App\Models\Property;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Spatie\Activitylog\ActivityLogStatus;

test('admin workspace screens render', function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    app(ActivityLogStatus::class)->disable();

    $admin = User::factory()->admin()->create();
    $admin->assignRole(UserRole::ADMIN->value);
    $lead = Lead::factory()->create();
    $service = Service::factory()->create();
    $this->actingAs($admin);

    $paths = [
        route('admin.dashboard'),
        route('admin.leads.index'),
        route('admin.leads.show', $lead),
        route('admin.appointments.index'),
        route('admin.appointments.create'),
        route('admin.installations.index'),
        route('admin.installations.create'),
        route('admin.users.index'),
        route('admin.users.edit', $admin),
        route('admin.services.index'),
        route('admin.services.create'),
        route('admin.services.edit', $service),
        route('admin.coverage-areas.index'),
        route('admin.faqs.index'),
        route('admin.partners.index'),
        route('admin.reports.index'),
        route('admin.notifications.index'),
    ];

    foreach ($paths as $path) {
        $this->get($path)->assertOk();
    }
});

test('sales can use operational screens but cannot access admin-only reports', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $sales = User::factory()->sales()->create();
    $sales->assignRole(UserRole::SALES->value);

    $this->actingAs($sales)->get(route('admin.dashboard'))->assertOk();
    $this->get(route('admin.leads.index'))->assertOk();
    $this->get(route('admin.appointments.index'))->assertOk();
    $this->get(route('admin.installations.index'))->assertOk();
    $this->get(route('admin.reports.index'))->assertForbidden();
});

test('technicians only see assigned appointments and can complete them', function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    app(ActivityLogStatus::class)->disable();

    $technician = User::factory()->technician()->create();
    $technician->assignRole(UserRole::TECHNICIAN->value);
    $otherTechnician = User::factory()->technician()->create();
    $otherTechnician->assignRole(UserRole::TECHNICIAN->value);
    $assigned = Appointment::factory()->create([
        'technician_id' => $technician->id,
        'lead_id' => Lead::factory()->create(['first_name' => 'AssignedClient'])->id,
    ]);
    Appointment::factory()->create([
        'technician_id' => $otherTechnician->id,
        'lead_id' => Lead::factory()->create(['first_name' => 'PrivateClient'])->id,
    ]);

    $this->actingAs($technician)
        ->get(route('admin.appointments.index'))
        ->assertOk()
        ->assertSee('AssignedClient')
        ->assertDontSee('PrivateClient');

    $this->patch(route('admin.appointments.status', $assigned), ['status' => 'realizada'])
        ->assertRedirect();
    $this->assertDatabaseHas('appointments', [
        'id' => $assigned->id,
        'status' => 'realizada',
    ]);
});

test('customer screens render and property data stays private', function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    app(ActivityLogStatus::class)->disable();

    $customer = User::factory()->create();
    $customer->assignRole(UserRole::CUSTOMER->value);
    $otherCustomer = User::factory()->create();
    $otherCustomer->assignRole(UserRole::CUSTOMER->value);
    $lead = Lead::factory()->create([
        'user_id' => $customer->id,
        'first_name' => 'VisibleCustomer',
    ]);
    Lead::factory()->create([
        'user_id' => $otherCustomer->id,
        'first_name' => 'HiddenCustomer',
    ]);
    Property::create([
        'user_id' => $customer->id,
        'property_type' => 'piso',
        'address' => 'Calle de prueba 1',
        'city' => 'Madrid',
        'province' => 'Madrid',
        'postal_code' => '28001',
    ]);
    $installation = Installation::factory()->create(['user_id' => $customer->id]);

    $this->actingAs($customer);
    $paths = [
        route('customer.dashboard'),
        route('customer.leads.index'),
        route('customer.leads.show', $lead),
        route('customer.installations.index'),
        route('customer.installations.show', $installation),
        route('customer.reviews.index'),
        route('customer.properties.index'),
        route('customer.profile.edit'),
    ];

    foreach ($paths as $path) {
        $this->get($path)->assertOk();
    }

    $this->get(route('customer.leads.index'))
        ->assertSee('VisibleCustomer')
        ->assertDontSee('HiddenCustomer');
});
