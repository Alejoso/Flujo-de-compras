<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadMedidaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('unidad_medidas')->insert([
            ['nombre' => 'Metro',   'abreviatura' => 'm',    'created_at' => now(), 'updated_at' => now()],  // id 1
            ['nombre' => 'Pulgada', 'abreviatura' => 'pulg', 'created_at' => now(), 'updated_at' => now()],  // id 2
            ['nombre' => 'Watts',    'abreviatura' => 'W',    'created_at' => now(), 'updated_at' => now()],  // id 3
            ['nombre' => 'Amperios', 'abreviatura' => 'A',    'created_at' => now(), 'updated_at' => now()],  // id 4
        ]);
    }
}
