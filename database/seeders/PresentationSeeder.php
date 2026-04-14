<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresentationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('presentations')->insert([
            ['name' => 'Rollo Grande', 'created_at' => now(), 'updated_at' => now()],  // id 1
            ['name' => 'Rollo Pequeño', 'created_at' => now(), 'updated_at' => now()],  // id 2
            ['name' => 'Unidad', 'created_at' => now(), 'updated_at' => now()],          // id 3
            ['name' => 'Rollo', 'created_at' => now(), 'updated_at' => now()],            // id 4
        ]);
    }
}
