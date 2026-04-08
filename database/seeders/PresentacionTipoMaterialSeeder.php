<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresentacionTipoMaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('presentacion_tipo_materiales')->insert([
            // Alambre #12 Rojo (tipoMaterialId 1) — Metro
            ['presentacionId' => 1, 'tipoMaterialId' => 1, 'cantidadPresentacion' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande  500 m
            ['presentacionId' => 2, 'tipoMaterialId' => 1, 'cantidadPresentacion' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m
            ['presentacionId' => 3, 'tipoMaterialId' => 1, 'cantidadPresentacion' => '1',   'created_at' => now(), 'updated_at' => now()],  // Unidad        1 m

            // Alambre #12 Negro (tipoMaterialId 2) — Metro
            ['presentacionId' => 1, 'tipoMaterialId' => 2, 'cantidadPresentacion' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande  500 m
            ['presentacionId' => 2, 'tipoMaterialId' => 2, 'cantidadPresentacion' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m
            ['presentacionId' => 3, 'tipoMaterialId' => 2, 'cantidadPresentacion' => '1',   'created_at' => now(), 'updated_at' => now()],  // Unidad        1 m

            // Alambre #12 Blanco (tipoMaterialId 3) — Metro
            ['presentacionId' => 1, 'tipoMaterialId' => 3, 'cantidadPresentacion' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande  500 m
            ['presentacionId' => 2, 'tipoMaterialId' => 3, 'cantidadPresentacion' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m
            ['presentacionId' => 3, 'tipoMaterialId' => 3, 'cantidadPresentacion' => '1',   'created_at' => now(), 'updated_at' => now()],  // Unidad        1 m

            // Alambre #12 Verde (tipoMaterialId 4) — Metro
            ['presentacionId' => 1, 'tipoMaterialId' => 4, 'cantidadPresentacion' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande  500 m
            ['presentacionId' => 2, 'tipoMaterialId' => 4, 'cantidadPresentacion' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m
            ['presentacionId' => 3, 'tipoMaterialId' => 4, 'cantidadPresentacion' => '1',   'created_at' => now(), 'updated_at' => now()],  // Unidad        1 m

            // Tubo Conduit PVC (tipoMaterialId 5) — Pulgada
            ['presentacionId' => 3, 'tipoMaterialId' => 5, 'cantidadPresentacion' => '1/2', 'created_at' => now(), 'updated_at' => now()],  // Unidad 1/2 pulg

            // Cable # 12 NEGRO (tipoMaterialId 6)
            ['presentacionId' => 4, 'tipoMaterialId' => 6,  'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['presentacionId' => 3, 'tipoMaterialId' => 6,  'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Cable # 12 ROJO (tipoMaterialId 7)
            ['presentacionId' => 4, 'tipoMaterialId' => 7,  'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['presentacionId' => 3, 'tipoMaterialId' => 7,  'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Cable # 12 VERDE (tipoMaterialId 8)
            ['presentacionId' => 4, 'tipoMaterialId' => 8,  'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['presentacionId' => 3, 'tipoMaterialId' => 8,  'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Cable # 12 BLANCO (tipoMaterialId 9)
            ['presentacionId' => 4, 'tipoMaterialId' => 9,  'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['presentacionId' => 3, 'tipoMaterialId' => 9,  'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Cable # 10 NEGRO (tipoMaterialId 10)
            ['presentacionId' => 4, 'tipoMaterialId' => 10, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['presentacionId' => 3, 'tipoMaterialId' => 10, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Cable # 10 ROJO (tipoMaterialId 11)
            ['presentacionId' => 4, 'tipoMaterialId' => 11, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['presentacionId' => 3, 'tipoMaterialId' => 11, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Cable # 10 VERDE (tipoMaterialId 12)
            ['presentacionId' => 4, 'tipoMaterialId' => 12, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['presentacionId' => 3, 'tipoMaterialId' => 12, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Panel LED 12 Watts (tipoMaterialId 13)
            ['presentacionId' => 3, 'tipoMaterialId' => 13, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Autoconector Cónico AMARILLOS (tipoMaterialId 14)
            ['presentacionId' => 3, 'tipoMaterialId' => 14, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Cerrucho PARA DRYWALL (tipoMaterialId 15)
            ['presentacionId' => 3, 'tipoMaterialId' => 15, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Herraje 50 X 50 (tipoMaterialId 16)
            ['presentacionId' => 3, 'tipoMaterialId' => 16, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Luz REDONDA 18 WATTS (tipoMaterialId 17)
            ['presentacionId' => 3, 'tipoMaterialId' => 17, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Breque 20 Amperios (tipoMaterialId 18)
            ['presentacionId' => 3, 'tipoMaterialId' => 18, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Transferencia Automática 63 Amperios (tipoMaterialId 19)
            ['presentacionId' => 3, 'tipoMaterialId' => 19, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Bala Sumergible 24W RGB (tipoMaterialId 20)
            ['presentacionId' => 3, 'tipoMaterialId' => 20, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Conector AMARILLOS (tipoMaterialId 21)
            ['presentacionId' => 3, 'tipoMaterialId' => 21, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Conector ROJOS (tipoMaterialId 22)
            ['presentacionId' => 3, 'tipoMaterialId' => 22, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Conector 1/2 (tipoMaterialId 23)
            ['presentacionId' => 3, 'tipoMaterialId' => 23, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Conector 3/4 (tipoMaterialId 24)
            ['presentacionId' => 3, 'tipoMaterialId' => 24, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tablero 36 circuitos (tipoMaterialId 25)
            ['presentacionId' => 3, 'tipoMaterialId' => 25, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tablero 12 circuitos (tipoMaterialId 26)
            ['presentacionId' => 3, 'tipoMaterialId' => 26, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Caja plástica 4x4 (tipoMaterialId 27)
            ['presentacionId' => 3, 'tipoMaterialId' => 27, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tapa PLUS (tipoMaterialId 28)
            ['presentacionId' => 3, 'tipoMaterialId' => 28, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tornillo drywall Estructura (tipoMaterialId 29)
            ['presentacionId' => 3, 'tipoMaterialId' => 29, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Curva 1/2 (tipoMaterialId 30)
            ['presentacionId' => 3, 'tipoMaterialId' => 30, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Curva 3/4 (tipoMaterialId 31)
            ['presentacionId' => 3, 'tipoMaterialId' => 31, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tubo Conduit 1/2 (tipoMaterialId 32)
            ['presentacionId' => 3, 'tipoMaterialId' => 32, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
            // Tubo Conduit 3/4 (tipoMaterialId 33)
            ['presentacionId' => 3, 'tipoMaterialId' => 33, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
