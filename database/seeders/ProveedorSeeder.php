<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proveedores')->insert([
            [
                'nit' => '800987654-1',
                'nombre' => 'Materiales El Constructor',
                'nombreAsesor' => 'Pedro Gomez',
                'numeroCuenta' => '123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
