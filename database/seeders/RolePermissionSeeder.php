<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create permissions
        $permissions = [
            // ASN permissions
            'asn.create-posting',
            'asn.edit-own-posting',
            'asn.delete-own-posting',
            'asn.view-own-dashboard',
            'asn.input-engagement',
            'asn.view-own-postings',

            // Pimpinan permissions
            'pimpinan.view-dashboard',
            'pimpinan.view-monitoring',
            'pimpinan.view-subordinates',
            'pimpinan.verify-posting',
            'pimpinan.view-reports',

            // Admin permissions
            'admin.manage-users',
            'admin.manage-wilayah',
            'admin.manage-pilar',
            'admin.manage-opd',
            'admin.verify-posting',
            'admin.view-reports',
            'admin.view-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $asnRole = Role::firstOrCreate(['name' => 'ASN']);
        $asnRole->syncPermissions([
            'asn.create-posting',
            'asn.edit-own-posting',
            'asn.delete-own-posting',
            'asn.view-own-dashboard',
            'asn.input-engagement',
            'asn.view-own-postings',
        ]);

        $pimpinanRole = Role::firstOrCreate(['name' => 'PIMPINAN']);
        $pimpinanRole->syncPermissions([
            'pimpinan.view-dashboard',
            'pimpinan.view-monitoring',
            'pimpinan.view-subordinates',
            'pimpinan.verify-posting',
            'pimpinan.view-reports',
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'ADMIN']);
        $adminRole->syncPermissions([
            'admin.manage-users',
            'admin.manage-wilayah',
            'admin.manage-pilar',
            'admin.manage-opd',
            'admin.verify-posting',
            'admin.view-reports',
            'admin.view-logs',
        ]);
    }
}
