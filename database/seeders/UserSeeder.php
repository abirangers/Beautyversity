<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default admin user
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'), // Default password: password
                'role' => 'admin',
                'last_login' => null,
            ]
        );
        
        // Create a default student user
        \App\Models\User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student User',
                'email' => 'student@example.com',
                'password' => bcrypt('password'), // Default password: password
                'role' => 'student',
                'last_login' => null,
            ]
        );
    }
}
