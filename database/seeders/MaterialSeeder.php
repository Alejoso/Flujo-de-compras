<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('materiales')->insert([
            ['descripcion' => 'Alambre #12',  'created_at' => now(), 'updated_at' => now()],  // id 1
            ['descripcion' => 'Tubo Conduit', 'created_at' => now(), 'updated_at' => now()],  // id 2
        ]);
    }
}
