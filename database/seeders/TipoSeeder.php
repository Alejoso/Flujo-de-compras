<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos')->insert([
            ['especificacion' => 'Rojo',        'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 1
            ['especificacion' => 'Negro',      'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 2
            ['especificacion' => 'Blanco',     'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 3
            ['especificacion' => 'Verde',      'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 4
            ['especificacion' => 'PVC',        'unidadMedidaId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 5
            ['especificacion' => '# 12 NEGRO',                    'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 6
            ['especificacion' => '# 12 ROJO',                     'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 7
            ['especificacion' => '# 12 VERDE',                    'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 8
            ['especificacion' => '# 12 BLANCO',                   'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 9
            ['especificacion' => '# 10 NEGRO',                    'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 10
            ['especificacion' => '# 10 ROJO',                     'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 11
            ['especificacion' => '# 10 VERDE',                    'unidadMedidaId' => 1, 'created_at' => now(), 'updated_at' => now()],  // id 12
            ['especificacion' => '12 Watts',                       'unidadMedidaId' => 3, 'created_at' => now(), 'updated_at' => now()],  // id 13
            ['especificacion' => 'AMARILLOS',                      'unidadMedidaId' => null, 'created_at' => now(), 'updated_at' => now()],  // id 14
            ['especificacion' => 'PARA DRYWALL',                   'unidadMedidaId' => null, 'created_at' => now(), 'updated_at' => now()],  // id 15
            ['especificacion' => '50 X 50',                        'unidadMedidaId' => null, 'created_at' => now(), 'updated_at' => now()],  // id 16
            ['especificacion' => 'REDONDA 18 WATTS',               'unidadMedidaId' => 3, 'created_at' => now(), 'updated_at' => now()],  // id 17
            ['especificacion' => '20 Amperios',                    'unidadMedidaId' => 4, 'created_at' => now(), 'updated_at' => now()],  // id 18
            ['especificacion' => '63 Amperios',                    'unidadMedidaId' => 4, 'created_at' => now(), 'updated_at' => now()],  // id 19
            ['especificacion' => '24W RGB IP68 0012163 C/T',       'unidadMedidaId' => 3, 'created_at' => now(), 'updated_at' => now()],  // id 20
            ['especificacion' => 'AMARILLOS',                      'unidadMedidaId' => null, 'created_at' => now(), 'updated_at' => now()],  // id 21
            ['especificacion' => 'ROJOS',                          'unidadMedidaId' => null, 'created_at' => now(), 'updated_at' => now()],  // id 22
            ['especificacion' => '1/2',                            'unidadMedidaId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 23
            ['especificacion' => '3/4',                            'unidadMedidaId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 24
            ['especificacion' => '36 circuitos monofásico 220V',   'unidadMedidaId' => null, 'created_at' => now(), 'updated_at' => now()],  // id 25
            ['especificacion' => '12 circuitos monofásico 220V',   'unidadMedidaId' => null, 'created_at' => now(), 'updated_at' => now()],  // id 26
            ['especificacion' => '4x4',                            'unidadMedidaId' => null, 'created_at' => now(), 'updated_at' => now()],  // id 27
            ['especificacion' => 'PLUS',                           'unidadMedidaId' => null, 'created_at' => now(), 'updated_at' => now()],  // id 28
            ['especificacion' => 'Estructura',                     'unidadMedidaId' => null, 'created_at' => now(), 'updated_at' => now()],  // id 29
            ['especificacion' => '1/2',                            'unidadMedidaId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 30
            ['especificacion' => '3/4',                            'unidadMedidaId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 31
            ['especificacion' => '1/2',                            'unidadMedidaId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 32
            ['especificacion' => '3/4',                            'unidadMedidaId' => 2, 'created_at' => now(), 'updated_at' => now()],  // id 33
        
        ]);
    }
}
