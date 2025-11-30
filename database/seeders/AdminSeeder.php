<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin
        User::create([
            'name' => 'Admin TravelGo',
            'email' => 'admin@travelgo.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create sample user
        User::create([
            'name' => 'User Demo',
            'email' => 'user@travelgo.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}
