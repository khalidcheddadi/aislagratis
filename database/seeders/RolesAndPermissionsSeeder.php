<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'leads.view', 'leads.create', 'leads.update', 'leads.delete', 'leads.export',
            'appointments.view', 'appointments.create', 'appointments.update', 'appointments.delete',
            'installations.view', 'installations.create', 'installations.update', 'installations.delete',
            'users.view', 'users.update', 'users.delete',
            'services.manage', 'faqs.manage', 'partners.manage',
            'coverage.manage', 'reports.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => UserRole::ADMIN->value]);
        $admin->syncPermissions(Permission::all());

        $sales = Role::firstOrCreate(['name' => UserRole::SALES->value]);
        $sales->syncPermissions([
            'leads.view', 'leads.create', 'leads.update', 'leads.export',
            'appointments.view', 'appointments.create', 'appointments.update',
            'installations.view', 'installations.create', 'installations.update',
        ]);

        $technician = Role::firstOrCreate(['name' => UserRole::TECHNICIAN->value]);
        $technician->syncPermissions([
            'appointments.view', 'appointments.update',
            'installations.view', 'installations.update',
        ]);

        Role::firstOrCreate(['name' => UserRole::CUSTOMER->value]);
    }
}
