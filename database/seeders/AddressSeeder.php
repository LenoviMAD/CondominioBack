<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('address')->insert([
            [
                'idTypeEntity' => 130,
                'idEntity' => 1,
                'description' => "Av. Principal macaracuay",
            ],
            [
                'idTypeEntity' => 131,
                'idEntity' => 1,
                'description' => "Colinas de Bello Monte",
            ],
        ]);
    }
}
