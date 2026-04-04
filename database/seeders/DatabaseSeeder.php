<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ClienteSeeder::class,
            ProveedorSeeder::class,
            ProyectoSeeder::class,
            PresentacionSeeder::class,
            UnidadMedidaSeeder::class,
            TipoSeeder::class,
            MaterialSeeder::class,
            TipoMaterialSeeder::class,
            PresentacionTipoMaterialSeeder::class,
        ]);
    }
}
