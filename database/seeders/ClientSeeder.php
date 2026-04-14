<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clients')->insert([
            [
                'name'       => 'Constructora Los Andes',
                'id_number'  => '900123456',
                'email'      => 'contacto@losandes.com',
                'phone'      => '3201112233',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Edificios del Norte S.A',
                'id_number'  => '900654321',
                'email'      => 'info@edificiosnorte.com',
                'phone'      => '3157778899',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
