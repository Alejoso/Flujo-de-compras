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
            ['descripcion' => 'Cable #10',                'created_at' => now(), 'updated_at' => now()],  // id 3
            ['descripcion' => 'Tubo EMT',                 'created_at' => now(), 'updated_at' => now()],  // id 4
            ['descripcion' => 'Tubo Conduit Gris',        'created_at' => now(), 'updated_at' => now()],  // id 5
            ['descripcion' => 'Caja Eléctrica Rectangular','created_at' => now(), 'updated_at' => now()],  // id 6
            ['descripcion' => 'Caja Eléctrica Cuadrada',  'created_at' => now(), 'updated_at' => now()],  // id 7
            ['descripcion' => 'Caja Eléctrica Octagonal', 'created_at' => now(), 'updated_at' => now()],  // id 8
            ['descripcion' => 'Tapa Eléctrica Rectangular','created_at' => now(), 'updated_at' => now()],  // id 9
            ['descripcion' => 'Tapa Eléctrica Cuadrada',  'created_at' => now(), 'updated_at' => now()],  // id 10
        ]);
    }
}
