<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ClientSeeder::class,
            SupplierSeeder::class,
            ProjectSeeder::class,
            PresentationSeeder::class,
            UnitOfMeasureSeeder::class,
            TypeSeeder::class,
            MaterialSeeder::class,
            MaterialTypeSeeder::class,
            PresentationMaterialTypeSeeder::class,
        ]);
    }
}
