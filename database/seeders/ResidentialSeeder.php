<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ResidentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('residential')->insert([
            [
                'idUser' => 1,
                'name' => 'Residencia Prueba',
                'email' => 'residencia@gmail.com',
                'nTowers' => 1,
            ],

        ]);
    }
}
