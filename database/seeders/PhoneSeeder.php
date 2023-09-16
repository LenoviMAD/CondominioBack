<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phone')->insert([
            [
                'idTypeEntity' => 130,
                'idEntity' => 1,
                'idTypePhone' => 73,
                'idAreaCode' => 92,
                'number' => '1112233',
            ],
            [
                'idTypeEntity' => 130,
                'idEntity' => 1,
                'idTypePhone' => 74,
                'idAreaCode' => 126,
                'number' => '1112233',
            ],
            [
                'idTypeEntity' => 131,
                'idEntity' => 1,
                'idTypePhone' => 73,
                'idAreaCode' => 93,
                'number' => '1236547',
            ],
            [
                'idTypeEntity' => 131,
                'idEntity' => 1,
                'idTypePhone' => 74,
                'idAreaCode' => 127,
                'number' => '1236547',
            ],
        ]);
    }
}
