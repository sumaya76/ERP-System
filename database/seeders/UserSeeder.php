<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::pluck('id', 'name');

        User::updateOrCreate(
            ['email' => 'admin@builddesk.com'],
            [
                'name' => 'Admin User',
                'role_id' => $roles['admin'],
                'password' => Hash::make('12345678'),
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'hr@builddesk.com'],
            [
                'name' => 'HR User',
                'role_id' => $roles['hr'],
                'password' => Hash::make('password123'),
                'status' => 'active',
            ]
        );

        $this->command->info('Users seeded successfully!');
    }
}
