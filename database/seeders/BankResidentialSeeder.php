<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BankResidentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bankResidential')->insert([
            [
                'idResidential' => 1,
                'idBank' => 5,
                'idTypeAccount' => 76,
                'idTypeRif' => 84,
                'rif' => '125552145',
                'bankAccount' => '65567578568568858877',
            ],

        ]);
    }
}
