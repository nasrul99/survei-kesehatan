<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // CREATE PERMISSIONS
        Permission::create(['name' => 'view-any Permission']);
        Permission::create(['name' => 'view Permission']);
        Permission::create(['name' => 'create Permission']);
        Permission::create(['name' => 'update Permission']);
        Permission::create(['name' => 'delete Permission']);
        Permission::create(['name' => 'force-delete Permission']);
        Permission::create(['name' => 'restore Permission']);

        Permission::create(['name' => 'view-any Role']);
        Permission::create(['name' => 'view Role']);
        Permission::create(['name' => 'create Role']);
        Permission::create(['name' => 'update Role']);
        Permission::create(['name' => 'delete Role']);
        Permission::create(['name' => 'force-delete Role']);
        Permission::create(['name' => 'restore Role']);

        // CREATE ROLES
        $superAdminRole = Role::create(['name' => 'Super Admin']);

        $pegawaiRole = Role::create(['name' => 'Pegawai']);

        // CREATE USERS
        User::create([
            'name' => 'Super Admin',
            'is_admin' => true,
            'email' => 'superadmin@nurulfikri.ac.id',
            'email_verified_at' => now(),
            'password' => Hash::make('super!@#'),
            'remember_token' => Str::random(10),
        ])->assignRole($superAdminRole);

        User::create([
            'name' => 'Nasrul',
            'is_admin' => false,
            'email' => 'nasrul@nurulfikri.ac.id',
            'email_verified_at' => now(),
            'password' => Hash::make('nasrul123!'),
            'remember_token' => Str::random(10),
        ])->assignRole($pegawaiRole);


    }
}
