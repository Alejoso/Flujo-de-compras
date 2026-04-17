<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresentationMaterialTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('presentation_material_types')->insert([
            // Alambre #12 Rojo (material_type_id 1) — Metro
            ['presentation_id' => 1, 'material_type_id' => 1, 'presentation_quantity' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande  500 m
            ['presentation_id' => 2, 'material_type_id' => 1, 'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m
            ['presentation_id' => 3, 'material_type_id' => 1, 'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],  // Unidad        1 m

            // Alambre #12 Negro (material_type_id 2) — Metro
            ['presentation_id' => 1, 'material_type_id' => 2, 'presentation_quantity' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande  500 m
            ['presentation_id' => 2, 'material_type_id' => 2, 'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m
            ['presentation_id' => 3, 'material_type_id' => 2, 'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],  // Unidad        1 m

            // Alambre #12 Blanco (material_type_id 3) — Metro
            ['presentation_id' => 1, 'material_type_id' => 3, 'presentation_quantity' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande  500 m
            ['presentation_id' => 2, 'material_type_id' => 3, 'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m
            ['presentation_id' => 3, 'material_type_id' => 3, 'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],  // Unidad        1 m

            // Alambre #12 Verde (material_type_id 4) — Metro
            ['presentation_id' => 1, 'material_type_id' => 4, 'presentation_quantity' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande  500 m
            ['presentation_id' => 2, 'material_type_id' => 4, 'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m
            ['presentation_id' => 3, 'material_type_id' => 4, 'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],  // Unidad        1 m

            // Tubo Conduit PVC (material_type_id 5) — Pulgada
            ['presentation_id' => 3, 'material_type_id' => 5, 'presentation_quantity' => '1/2', 'created_at' => now(), 'updated_at' => now()],  // Unidad 1/2 pulg

            // Cable # 12 NEGRO (material_type_id 6)
            ['presentation_id' => 4, 'material_type_id' => 6,  'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],
            ['presentation_id' => 3, 'material_type_id' => 6,  'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],
            // Cable # 12 ROJO (material_type_id 7)
            ['presentation_id' => 4, 'material_type_id' => 7,  'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],
            ['presentation_id' => 3, 'material_type_id' => 7,  'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],
            // Cable # 12 VERDE (material_type_id 8)
            ['presentation_id' => 4, 'material_type_id' => 8,  'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],
            ['presentation_id' => 3, 'material_type_id' => 8,  'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],
            // Cable # 12 BLANCO (material_type_id 9)
            ['presentation_id' => 4, 'material_type_id' => 9,  'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],
            ['presentation_id' => 3, 'material_type_id' => 9,  'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],
            // Cable # 10 NEGRO (material_type_id 10)
            ['presentation_id' => 4, 'material_type_id' => 10, 'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],
            ['presentation_id' => 3, 'material_type_id' => 10, 'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],
            // Cable # 10 ROJO (material_type_id 11)
            ['presentation_id' => 4, 'material_type_id' => 11, 'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],
            ['presentation_id' => 3, 'material_type_id' => 11, 'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],
            // Cable # 10 VERDE (material_type_id 12)
            ['presentation_id' => 4, 'material_type_id' => 12, 'presentation_quantity' => '100', 'created_at' => now(), 'updated_at' => now()],
            ['presentation_id' => 3, 'material_type_id' => 12, 'presentation_quantity' => '1',   'created_at' => now(), 'updated_at' => now()],
            // Panel LED 12 Watts (material_type_id 13)
            ['presentation_id' => 3, 'material_type_id' => 13, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Autoconector Cónico AMARILLOS (material_type_id 14)
            ['presentation_id' => 3, 'material_type_id' => 14, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Cerrucho PARA DRYWALL (material_type_id 15)
            ['presentation_id' => 3, 'material_type_id' => 15, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Herraje 50 X 50 (material_type_id 16)
            ['presentation_id' => 3, 'material_type_id' => 16, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Luz REDONDA 18 WATTS (material_type_id 17)
            ['presentation_id' => 3, 'material_type_id' => 17, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Breque 20 Amperios (material_type_id 18)
            ['presentation_id' => 3, 'material_type_id' => 18, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Transferencia Automática 63 Amperios (material_type_id 19)
            ['presentation_id' => 3, 'material_type_id' => 19, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Bala Sumergible 24W RGB (material_type_id 20)
            ['presentation_id' => 3, 'material_type_id' => 20, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Conector AMARILLOS (material_type_id 21)
            ['presentation_id' => 3, 'material_type_id' => 21, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Conector ROJOS (material_type_id 22)
            ['presentation_id' => 3, 'material_type_id' => 22, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Conector 1/2 (material_type_id 23)
            ['presentation_id' => 3, 'material_type_id' => 23, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Conector 3/4 (material_type_id 24)
            ['presentation_id' => 3, 'material_type_id' => 24, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tablero 36 circuitos (material_type_id 25)
            ['presentation_id' => 3, 'material_type_id' => 25, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tablero 12 circuitos (material_type_id 26)
            ['presentation_id' => 3, 'material_type_id' => 26, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Caja plástica 4x4 (material_type_id 27)
            ['presentation_id' => 3, 'material_type_id' => 27, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tapa PLUS (material_type_id 28)
            ['presentation_id' => 3, 'material_type_id' => 28, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tornillo drywall Estructura (material_type_id 29)
            ['presentation_id' => 3, 'material_type_id' => 29, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Curva 1/2 (material_type_id 30)
            ['presentation_id' => 3, 'material_type_id' => 30, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Curva 3/4 (material_type_id 31)
            ['presentation_id' => 3, 'material_type_id' => 31, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tubo Conduit 1/2 (material_type_id 32)
            ['presentation_id' => 3, 'material_type_id' => 32, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tubo Conduit 3/4 (material_type_id 33)
            ['presentation_id' => 3, 'material_type_id' => 33, 'presentation_quantity' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
