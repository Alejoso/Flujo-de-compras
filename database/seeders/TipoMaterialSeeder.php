<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoMaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipo_materiales')->insert([
            ['materialId' => 1, 'tipoId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 1: Alambre #12 Rojo
            ['materialId' => 1, 'tipoId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 2: Alambre #12 Negro
            ['materialId' => 1, 'tipoId' => 3, 'created_at' => now(), 'updated_at' => now()],  // id 3: Alambre #12 Blanco
            ['materialId' => 1, 'tipoId' => 4, 'created_at' => now(), 'updated_at' => now()],  // id 4: Alambre #12 Verde
            ['materialId' => 2, 'tipoId' => 5, 'created_at' => now(), 'updated_at' => now()],  // id 5: Tubo Conduit PVC
        ]);
    }
}
