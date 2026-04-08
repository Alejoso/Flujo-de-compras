<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('materiales')->insert([
            ['descripcion' => 'Alambre #12',              'created_at' => now(), 'updated_at' => now()],  // id 1
            ['descripcion' => 'Tubo Conduit',             'created_at' => now(), 'updated_at' => now()],  // id 2
            ['descripcion' => 'Cable',                    'created_at' => now(), 'updated_at' => now()],  // id 3
            ['descripcion' => 'Panel LED',                'created_at' => now(), 'updated_at' => now()],  // id 4
            ['descripcion' => 'Autoconector Cónico',      'created_at' => now(), 'updated_at' => now()],  // id 5
            ['descripcion' => 'Cerrucho',                 'created_at' => now(), 'updated_at' => now()],  // id 6
            ['descripcion' => 'Herraje',                  'created_at' => now(), 'updated_at' => now()],  // id 7
            ['descripcion' => 'Luz de sobreponer LED',    'created_at' => now(), 'updated_at' => now()],  // id 8
            ['descripcion' => 'Breque',                   'created_at' => now(), 'updated_at' => now()],  // id 9
            ['descripcion' => 'Transferencia Automática', 'created_at' => now(), 'updated_at' => now()],  // id 10
            ['descripcion' => 'Bala Sumergible',          'created_at' => now(), 'updated_at' => now()],  // id 11
            ['descripcion' => 'Conector',                 'created_at' => now(), 'updated_at' => now()],  // id 12
            ['descripcion' => 'Tablero',                  'created_at' => now(), 'updated_at' => now()],  // id 13
            ['descripcion' => 'Caja plástica',            'created_at' => now(), 'updated_at' => now()],  // id 14
            ['descripcion' => 'Tapa',                     'created_at' => now(), 'updated_at' => now()],  // id 15
            ['descripcion' => 'Tornillo drywall',         'created_at' => now(), 'updated_at' => now()],  // id 16
            ['descripcion' => 'Curva',                    'created_at' => now(), 'updated_at' => now()],  // id 17
        
        ]);
    }
}
