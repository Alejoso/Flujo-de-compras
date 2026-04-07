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

            // Cable #10 Rojo (tipoMaterialId 6) — Metro
            ['presentacionId' => 1, 'tipoMaterialId' => 6, 'cantidadPresentacion' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande 500 m
            ['presentacionId' => 2, 'tipoMaterialId' => 6, 'cantidadPresentacion' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m

            // Cable #10 Negro (tipoMaterialId 7) — Metro
            ['presentacionId' => 1, 'tipoMaterialId' => 7, 'cantidadPresentacion' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande 500 m
            ['presentacionId' => 2, 'tipoMaterialId' => 7, 'cantidadPresentacion' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m

            // Cable #10 Blanco (tipoMaterialId 8) — Metro
            ['presentacionId' => 1, 'tipoMaterialId' => 8, 'cantidadPresentacion' => '500', 'created_at' => now(), 'updated_at' => now()],  // Rollo Grande 500 m
            ['presentacionId' => 2, 'tipoMaterialId' => 8, 'cantidadPresentacion' => '100', 'created_at' => now(), 'updated_at' => now()],  // Rollo Pequeño 100 m

            // Tubo EMT (tipoMaterialId 9) — Pulgada
            ['presentacionId' => 3, 'tipoMaterialId' => 9, 'cantidadPresentacion' => '1/2', 'created_at' => now(), 'updated_at' => now()],  // Unidad 1/2 pulg
            ['presentacionId' => 3, 'tipoMaterialId' => 9, 'cantidadPresentacion' => '3/4', 'created_at' => now(), 'updated_at' => now()],  // Unidad 3/4 pulg
            ['presentacionId' => 3, 'tipoMaterialId' => 9, 'cantidadPresentacion' => '1',   'created_at' => now(), 'updated_at' => now()],  // Unidad 1 pulg

            // Tubo Conduit Gris (tipoMaterialId 10) — Pulgada
            ['presentacionId' => 3, 'tipoMaterialId' => 10, 'cantidadPresentacion' => '1/2', 'created_at' => now(), 'updated_at' => now()],  // Unidad 1/2 pulg

            // Caja Eléctrica Rectangular (tipoMaterialId 11)
            ['presentacionId' => 3, 'tipoMaterialId' => 11, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],  // Unidad

            // Caja Eléctrica Cuadrada (tipoMaterialId 12)
            ['presentacionId' => 3, 'tipoMaterialId' => 12, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],  // Unidad

            // Caja Eléctrica Octagonal (tipoMaterialId 13)
            ['presentacionId' => 3, 'tipoMaterialId' => 13, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],  // Unidad

            // Tapa Eléctrica Rectangular (tipoMaterialId 14)
            ['presentacionId' => 3, 'tipoMaterialId' => 14, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],  // Unidad

            // Tapa Eléctrica Cuadrada (tipoMaterialId 15)
            ['presentacionId' => 3, 'tipoMaterialId' => 15, 'cantidadPresentacion' => '1', 'created_at' => now(), 'updated_at' => now()],  // Unidad
        ]);
    }
}
