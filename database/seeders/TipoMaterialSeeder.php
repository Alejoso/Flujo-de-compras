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
            
            // Cable #10 (materialId 3) — Colores
            ['materialId' => 3, 'tipoId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 6: Cable #10 Rojo
            ['materialId' => 3, 'tipoId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 7: Cable #10 Negro
            ['materialId' => 3, 'tipoId' => 3, 'created_at' => now(), 'updated_at' => now()],  // id 8: Cable #10 Blanco
            
            // Tubo EMT (materialId 4) — EMT
            ['materialId' => 4, 'tipoId' => 6, 'created_at' => now(), 'updated_at' => now()],  // id 9: Tubo EMT
            
            // Tubo Conduit Gris (materialId 5) — Gris
            ['materialId' => 5, 'tipoId' => 7, 'created_at' => now(), 'updated_at' => now()],  // id 10: Tubo Conduit Gris
            
            // Caja Eléctrica Rectangular (materialId 6)
            ['materialId' => 6, 'tipoId' => 8, 'created_at' => now(), 'updated_at' => now()],  // id 11: Caja Rectangular
            
            // Caja Eléctrica Cuadrada (materialId 7)
            ['materialId' => 7, 'tipoId' => 9, 'created_at' => now(), 'updated_at' => now()],  // id 12: Caja Cuadrada
            
            // Caja Eléctrica Octagonal (materialId 8)
            ['materialId' => 8, 'tipoId' => 10, 'created_at' => now(), 'updated_at' => now()],  // id 13: Caja Octagonal
            
            // Tapa Eléctrica Rectangular (materialId 9)
            ['materialId' => 9, 'tipoId' => 8, 'created_at' => now(), 'updated_at' => now()],  // id 14: Tapa Rectangular
            
            // Tapa Eléctrica Cuadrada (materialId 10)
            ['materialId' => 10, 'tipoId' => 9, 'created_at' => now(), 'updated_at' => now()],  // id 15: Tapa Cuadrada
        ]);
    }
}
