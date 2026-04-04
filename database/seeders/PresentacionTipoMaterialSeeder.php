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
        ]);
    }
}
