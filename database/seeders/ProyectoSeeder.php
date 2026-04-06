<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proyectos')->insert([
            [
                'nombre' => 'Instalacion Electrica Sede Principal',
                'direccion' => 'Calle 50 #30-10',
                'ciudad' => 'Medellin',
                'costoTotal' => 85000000,
                'estado' => 'En Negociación',
                'clienteId' => 1,
                'creadoPor' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Remodelacion Torre Norte',
                'direccion' => 'Carrera 43 #12-5',
                'ciudad' => 'Bogota',
                'costoTotal' => 120000000,
                'estado' => 'En Ejecución',
                'clienteId' => 2,
                'creadoPor' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
