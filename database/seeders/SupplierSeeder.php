<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'nit'            => '800987654-1',
                'name'           => 'Materiales El Constructor',
                'advisor_name'   => 'Pedro Gomez',
                'account_number' => '123456789',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
