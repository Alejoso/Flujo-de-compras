<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('material_types')->insert([
            ['material_id' => 1,  'type_id' => 1,  'created_at' => now(), 'updated_at' => now()],  // id 1:  Alambre #12 Rojo
            ['material_id' => 1,  'type_id' => 2,  'created_at' => now(), 'updated_at' => now()],  // id 2:  Alambre #12 Negro
            ['material_id' => 1,  'type_id' => 3,  'created_at' => now(), 'updated_at' => now()],  // id 3:  Alambre #12 Blanco
            ['material_id' => 1,  'type_id' => 4,  'created_at' => now(), 'updated_at' => now()],  // id 4:  Alambre #12 Verde
            ['material_id' => 2,  'type_id' => 5,  'created_at' => now(), 'updated_at' => now()],  // id 5:  Tubo Conduit PVC
            ['material_id' => 3,  'type_id' => 6,  'created_at' => now(), 'updated_at' => now()],  // id 6:  Cable #12 Negro
            ['material_id' => 3,  'type_id' => 7,  'created_at' => now(), 'updated_at' => now()],  // id 7:  Cable #12 Rojo
            ['material_id' => 3,  'type_id' => 8,  'created_at' => now(), 'updated_at' => now()],  // id 8:  Cable #12 Verde
            ['material_id' => 3,  'type_id' => 9,  'created_at' => now(), 'updated_at' => now()],  // id 9:  Cable #12 Blanco
            ['material_id' => 18, 'type_id' => 10, 'created_at' => now(), 'updated_at' => now()],  // id 10: Cable #10 Negro
            ['material_id' => 18, 'type_id' => 11, 'created_at' => now(), 'updated_at' => now()],  // id 11: Cable #10 Rojo
            ['material_id' => 18, 'type_id' => 12, 'created_at' => now(), 'updated_at' => now()],  // id 12: Cable #10 Verde
            ['material_id' => 4,  'type_id' => 13, 'created_at' => now(), 'updated_at' => now()],  // id 13: Panel LED 12 Watts
            ['material_id' => 5,  'type_id' => 14, 'created_at' => now(), 'updated_at' => now()],  // id 14: Autoconector Cónico AMARILLOS
            ['material_id' => 6,  'type_id' => 15, 'created_at' => now(), 'updated_at' => now()],  // id 15: Cerrucho PARA DRYWALL
            ['material_id' => 7,  'type_id' => 16, 'created_at' => now(), 'updated_at' => now()],  // id 16: Herraje 50 X 50
            ['material_id' => 8,  'type_id' => 17, 'created_at' => now(), 'updated_at' => now()],  // id 17: Luz REDONDA 18 WATTS
            ['material_id' => 9,  'type_id' => 18, 'created_at' => now(), 'updated_at' => now()],  // id 18: Breque 20 Amperios
            ['material_id' => 10, 'type_id' => 19, 'created_at' => now(), 'updated_at' => now()],  // id 19: Transferencia 63 Amperios
            ['material_id' => 11, 'type_id' => 20, 'created_at' => now(), 'updated_at' => now()],  // id 20: Bala 24W RGB IP68
            ['material_id' => 12, 'type_id' => 21, 'created_at' => now(), 'updated_at' => now()],  // id 21: Conector AMARILLOS
            ['material_id' => 12, 'type_id' => 22, 'created_at' => now(), 'updated_at' => now()],  // id 22: Conector ROJOS
            ['material_id' => 12, 'type_id' => 23, 'created_at' => now(), 'updated_at' => now()],  // id 23: Conector 1/2
            ['material_id' => 12, 'type_id' => 24, 'created_at' => now(), 'updated_at' => now()],  // id 24: Conector 3/4
            ['material_id' => 13, 'type_id' => 25, 'created_at' => now(), 'updated_at' => now()],  // id 25: Tablero 36 circ 220V
            ['material_id' => 13, 'type_id' => 26, 'created_at' => now(), 'updated_at' => now()],  // id 26: Tablero 12 circ 220V
            ['material_id' => 14, 'type_id' => 27, 'created_at' => now(), 'updated_at' => now()],  // id 27: Caja plástica 4x4
            ['material_id' => 15, 'type_id' => 28, 'created_at' => now(), 'updated_at' => now()],  // id 28: Tapa PLUS
            ['material_id' => 16, 'type_id' => 29, 'created_at' => now(), 'updated_at' => now()],  // id 29: Tornillo Estructura
            ['material_id' => 17, 'type_id' => 30, 'created_at' => now(), 'updated_at' => now()],  // id 30: Curva 1/2
            ['material_id' => 17, 'type_id' => 31, 'created_at' => now(), 'updated_at' => now()],  // id 31: Curva 3/4
            ['material_id' => 2,  'type_id' => 32, 'created_at' => now(), 'updated_at' => now()],  // id 32: Tubo Conduit 1/2
            ['material_id' => 2,  'type_id' => 33, 'created_at' => now(), 'updated_at' => now()],  // id 33: Tubo Conduit 3/4
        ]);
    }
}
