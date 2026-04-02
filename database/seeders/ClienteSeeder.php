<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clientes')->insert([
            [
                'nombre'     => 'Constructora Los Andes',
                'cedula'     => '900123456',
                'correo'     => 'contacto@losandes.com',
                'celular'    => '3201112233',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Edificios del Norte S.A',
                'cedula'     => '900654321',
                'correo'     => 'info@edificiosnorte.com',
                'celular'    => '3157778899',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
