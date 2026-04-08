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
            ['materialId' => 3, 'tipoId' => 6,  'created_at' => now(), 'updated_at' => now()],  // id 6:  Cable # 12 NEGRO
            ['materialId' => 3, 'tipoId' => 7,  'created_at' => now(), 'updated_at' => now()],  // id 7:  Cable # 12 ROJO
            ['materialId' => 3, 'tipoId' => 8,  'created_at' => now(), 'updated_at' => now()],  // id 8:  Cable # 12 VERDE
            ['materialId' => 3, 'tipoId' => 9,  'created_at' => now(), 'updated_at' => now()],  // id 9:  Cable # 12 BLANCO
            ['materialId' => 3, 'tipoId' => 10, 'created_at' => now(), 'updated_at' => now()],  // id 10: Cable # 10 NEGRO
            ['materialId' => 3, 'tipoId' => 11, 'created_at' => now(), 'updated_at' => now()],  // id 11: Cable # 10 ROJO
            ['materialId' => 3, 'tipoId' => 12, 'created_at' => now(), 'updated_at' => now()],  // id 12: Cable # 10 VERDE
            ['materialId' => 4, 'tipoId' => 13, 'created_at' => now(), 'updated_at' => now()],  // id 13: Panel LED 12 Watts
            ['materialId' => 5, 'tipoId' => 14, 'created_at' => now(), 'updated_at' => now()],  // id 14: Autoconector Cónico AMARILLOS
            ['materialId' => 6, 'tipoId' => 15, 'created_at' => now(), 'updated_at' => now()],  // id 15: Cerrucho PARA DRYWALL
            ['materialId' => 7, 'tipoId' => 16, 'created_at' => now(), 'updated_at' => now()],  // id 16: Herraje 50 X 50
            ['materialId' => 8, 'tipoId' => 17, 'created_at' => now(), 'updated_at' => now()],  // id 17: Luz REDONDA 18 WATTS
            ['materialId' => 9, 'tipoId' => 18, 'created_at' => now(), 'updated_at' => now()],  // id 18: Breque 20 Amperios
            ['materialId' => 10, 'tipoId' => 19, 'created_at' => now(), 'updated_at' => now()], // id 19: Transferencia 63 Amperios
            ['materialId' => 11, 'tipoId' => 20, 'created_at' => now(), 'updated_at' => now()], // id 20: Bala 24W RGB IP68
            ['materialId' => 12, 'tipoId' => 21, 'created_at' => now(), 'updated_at' => now()], // id 21: Conector AMARILLOS
            ['materialId' => 12, 'tipoId' => 22, 'created_at' => now(), 'updated_at' => now()], // id 22: Conector ROJOS
            ['materialId' => 12, 'tipoId' => 23, 'created_at' => now(), 'updated_at' => now()], // id 23: Conector 1/2
            ['materialId' => 12, 'tipoId' => 24, 'created_at' => now(), 'updated_at' => now()], // id 24: Conector 3/4
            ['materialId' => 13, 'tipoId' => 25, 'created_at' => now(), 'updated_at' => now()], // id 25: Tablero 36 circ 220V
            ['materialId' => 13, 'tipoId' => 26, 'created_at' => now(), 'updated_at' => now()], // id 26: Tablero 12 circ 220V
            ['materialId' => 14, 'tipoId' => 27, 'created_at' => now(), 'updated_at' => now()], // id 27: Caja plástica 4x4
            ['materialId' => 15, 'tipoId' => 28, 'created_at' => now(), 'updated_at' => now()], // id 28: Tapa PLUS
            ['materialId' => 16, 'tipoId' => 29, 'created_at' => now(), 'updated_at' => now()], // id 29: Tornillo Estructura
            ['materialId' => 17, 'tipoId' => 30, 'created_at' => now(), 'updated_at' => now()], // id 30: Curva 1/2
            ['materialId' => 17, 'tipoId' => 31, 'created_at' => now(), 'updated_at' => now()], // id 31: Curva 3/4
            ['materialId' => 2,  'tipoId' => 32, 'created_at' => now(), 'updated_at' => now()], // id 32: Tubo Conduit 1/2
            ['materialId' => 2,  'tipoId' => 33, 'created_at' => now(), 'updated_at' => now()], // id 33: Tubo Conduit 3/4
        ]);
    }
}
