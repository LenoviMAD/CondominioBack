<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class IdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('identity')->insert([
            [
                'idTypeEntity' => 130,
                'idEntity' => 1,
                'idTypeIdentity' => 78,
                'idTypeDocument' => 80,
                'number' => '25486174',
            ],
            [
                'idTypeEntity' => 131,
                'idEntity' => 1,
                'idTypeIdentity' => 79,
                'idTypeDocument' => 84,
                'number' => '275486945',
            ],
        ]);
    }
}
