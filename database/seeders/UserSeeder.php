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
                'rol' => 'admin',
                'cedula' => '1000000001',
                'sueldo' => 5000000,
                'numeroTelefono' => '3001234567',
                'recibeNotificaciones' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Juan Trujillo',
                'email' => 'tecnico@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'rol' => 'tecnico',
                'cedula' => '1000000002',
                'sueldo' => 3000000,
                'numeroTelefono' => '3009876543',
                'recibeNotificaciones' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
