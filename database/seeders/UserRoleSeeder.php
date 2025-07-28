<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['dokter', 'apoteker','admin','superadmin'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Buat user dokter
        $dokter = User::firstOrCreate(
            ['email' => 'dokter@example.com'],
            [
                'name' => 'Dokter Umum',
                'password' => Hash::make('password'),
            ]
        );
        $dokter->assignRole('dokter');

        // Buat user apoteker
        $apoteker = User::firstOrCreate(
            ['email' => 'apoteker@example.com'],
            [
                'name' => 'Apoteker Senior',
                'password' => Hash::make('password'),
            ]
        );
        $apoteker->assignRole('apoteker');

        // Buat user admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Buat user superadmin
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'superadmin',
                'password' => Hash::make('password'),
            ]
        );
        $superadmin->assignRole('superadmin');
    }
}
