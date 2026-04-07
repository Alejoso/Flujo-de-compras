<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos')->insert([
            ['especificacion' => 'Rojo',        'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 1
            ['especificacion' => 'Negro',      'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 2
            ['especificacion' => 'Blanco',     'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 3
            ['especificacion' => 'Verde',      'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 4
            ['especificacion' => 'PVC',        'unidadMedidaId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 5
            ['especificacion' => 'EMT',        'unidadMedidaId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 6
            ['especificacion' => 'Gris',       'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 7
            ['especificacion' => 'Rectangular','unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 8
            ['especificacion' => 'Cuadrada',   'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 9
            ['especificacion' => 'Octagonal',  'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 10
        ]);
    }
}
