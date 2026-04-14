<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('projects')->insert([
            [
                'name' => 'Instalacion Electrica Sede Principal',
                'address' => 'Calle 50 #30-10',
                'city' => 'Medellin',
                'total_cost' => 85000000,
                'status' => 'Negotiation',
                'client_id' => 1,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Remodelacion Torre Norte',
                'address' => 'Carrera 43 #12-5',
                'city' => 'Bogota',
                'total_cost' => 120000000,
                'status' => 'In Progress',
                'client_id' => 2,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
