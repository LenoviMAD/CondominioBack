<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('person')->insert([
            [
                'idUser' => 1,
                'name' => 'Carlos',
                'secondName' => 'Eduardo',
                'surname' => 'Mora',
                'secondSurname' => 'Cruz',
                'birthday' => '2015-05-07',
            ],
        ]);
    }
}
