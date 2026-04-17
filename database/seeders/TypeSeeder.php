<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('types')->insert([
            ['specification' => 'Rojo', 'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 1
            ['specification' => 'Negro', 'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 2
            ['specification' => 'Blanco', 'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 3
            ['specification' => 'Verde', 'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 4
            ['specification' => 'PVC', 'unit_of_measure_id' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 5
            ['specification' => 'Negro', 'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 6  — Cable #12
            ['specification' => 'Rojo',  'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 7  — Cable #12
            ['specification' => 'Verde', 'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 8  — Cable #12
            ['specification' => 'Blanco', 'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 9  — Cable #12
            ['specification' => 'Negro', 'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 10 — Cable #10
            ['specification' => 'Rojo',  'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 11 — Cable #10
            ['specification' => 'Verde', 'unit_of_measure_id' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 12 — Cable #10
            ['specification' => '12 Watts', 'unit_of_measure_id' => 3, 'created_at' => now(), 'updated_at' => now()],  // id 13
            ['specification' => 'AMARILLOS', 'unit_of_measure_id' => null, 'created_at' => now(), 'updated_at' => now()],  // id 14
            ['specification' => 'PARA DRYWALL', 'unit_of_measure_id' => null, 'created_at' => now(), 'updated_at' => now()],  // id 15
            ['specification' => '50 X 50', 'unit_of_measure_id' => null, 'created_at' => now(), 'updated_at' => now()],  // id 16
            ['specification' => 'REDONDA 18 WATTS', 'unit_of_measure_id' => 3, 'created_at' => now(), 'updated_at' => now()],  // id 17
            ['specification' => '20 Amperios', 'unit_of_measure_id' => 4, 'created_at' => now(), 'updated_at' => now()],  // id 18
            ['specification' => '63 Amperios', 'unit_of_measure_id' => 4, 'created_at' => now(), 'updated_at' => now()],  // id 19
            ['specification' => '24W RGB IP68 0012163 C/T', 'unit_of_measure_id' => 3, 'created_at' => now(), 'updated_at' => now()],  // id 20
            ['specification' => 'AMARILLOS', 'unit_of_measure_id' => null, 'created_at' => now(), 'updated_at' => now()],  // id 21
            ['specification' => 'ROJOS', 'unit_of_measure_id' => null, 'created_at' => now(), 'updated_at' => now()],  // id 22
            ['specification' => '1/2', 'unit_of_measure_id' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 23
            ['specification' => '3/4', 'unit_of_measure_id' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 24
            ['specification' => '36 circuitos monofásico 220V', 'unit_of_measure_id' => null, 'created_at' => now(), 'updated_at' => now()],  // id 25
            ['specification' => '12 circuitos monofásico 220V', 'unit_of_measure_id' => null, 'created_at' => now(), 'updated_at' => now()],  // id 26
            ['specification' => '4x4', 'unit_of_measure_id' => null, 'created_at' => now(), 'updated_at' => now()],  // id 27
            ['specification' => 'PLUS', 'unit_of_measure_id' => null, 'created_at' => now(), 'updated_at' => now()],  // id 28
            ['specification' => 'Estructura', 'unit_of_measure_id' => null, 'created_at' => now(), 'updated_at' => now()],  // id 29
            ['specification' => '1/2', 'unit_of_measure_id' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 30
            ['specification' => '3/4', 'unit_of_measure_id' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 31
            ['specification' => '1/2', 'unit_of_measure_id' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 32
            ['specification' => '3/4', 'unit_of_measure_id' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 33
        ]);
    }
}
