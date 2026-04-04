<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresentacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('presentaciones')->insert([
            ['nombre' => 'Rollo Grande',  'created_at' => now(), 'updated_at' => now()],  // id 1
            ['nombre' => 'Rollo Pequeño', 'created_at' => now(), 'updated_at' => now()],  // id 2
            ['nombre' => 'Unidad',        'created_at' => now(), 'updated_at' => now()],  // id 3
        ]);
    }
}
