<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Sistema',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
                'id_number' => '1000000001',
                'salary' => 5000000,
                'phone_number' => '3001234567',
                'receives_notifications' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Juan Trujillo',
                'email' => 'tecnico@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'technician',
                'id_number' => '1000000002',
                'salary' => 3000000,
                'phone_number' => '3009876543',
                'receives_notifications' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
