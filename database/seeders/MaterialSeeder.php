<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('materials')->insert([
            ['description' => 'Alambre #12', 'created_at' => now(), 'updated_at' => now()],  // id 1
            ['description' => 'Tubo Conduit', 'created_at' => now(), 'updated_at' => now()],  // id 2
            ['description' => 'Cable #12', 'created_at' => now(), 'updated_at' => now()],  // id 3
            ['description' => 'Panel LED', 'created_at' => now(), 'updated_at' => now()],  // id 4
            ['description' => 'Autoconector Cónico', 'created_at' => now(), 'updated_at' => now()],  // id 5
            ['description' => 'Cerrucho', 'created_at' => now(), 'updated_at' => now()],  // id 6
            ['description' => 'Herraje', 'created_at' => now(), 'updated_at' => now()],  // id 7
            ['description' => 'Luz de sobreponer LED', 'created_at' => now(), 'updated_at' => now()],  // id 8
            ['description' => 'Breque', 'created_at' => now(), 'updated_at' => now()],  // id 9
            ['description' => 'Transferencia Automática', 'created_at' => now(), 'updated_at' => now()],  // id 10
            ['description' => 'Bala Sumergible', 'created_at' => now(), 'updated_at' => now()],  // id 11
            ['description' => 'Conector', 'created_at' => now(), 'updated_at' => now()],  // id 12
            ['description' => 'Tablero', 'created_at' => now(), 'updated_at' => now()],  // id 13
            ['description' => 'Caja plástica', 'created_at' => now(), 'updated_at' => now()],  // id 14
            ['description' => 'Tapa', 'created_at' => now(), 'updated_at' => now()],  // id 15
            ['description' => 'Tornillo drywall', 'created_at' => now(), 'updated_at' => now()],  // id 16
            ['description' => 'Curva', 'created_at' => now(), 'updated_at' => now()],  // id 17
            ['description' => 'Cable #10', 'created_at' => now(), 'updated_at' => now()],  // id 18
        ]);
    }
}
