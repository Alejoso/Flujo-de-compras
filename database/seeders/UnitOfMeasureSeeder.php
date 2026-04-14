<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitOfMeasureSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('unit_of_measures')->insert([
            ['name' => 'Metro', 'abbreviation' => 'm', 'created_at' => now(), 'updated_at' => now()],      // id 1
            ['name' => 'Pulgada', 'abbreviation' => 'pulg', 'created_at' => now(), 'updated_at' => now()], // id 2
            ['name' => 'Watts', 'abbreviation' => 'W', 'created_at' => now(), 'updated_at' => now()],      // id 3
            ['name' => 'Amperios', 'abbreviation' => 'A', 'created_at' => now(), 'updated_at' => now()],   // id 4
        ]);
    }
}
