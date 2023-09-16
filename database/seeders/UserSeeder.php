<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            [
                'idRole' => 2,
                'email' => 'admin@condominio.com',
                'password' => bcrypt('admin'),
                'status' => '53',
                // 'type' => '61',
            ],
            [
                'idRole' => 1,
                'email' => 'superusuario@condominio.com',
                'password' => bcrypt('admin'),
                'status' => '53',
                // 'type' => '61',
            ],
            [
                'idRole' => 4,
                'email' => 'cliente@condominio.com',
                'password' => bcrypt('cliente'),
                'status' => '53',
                // 'type' => '61',
            ],

        ]);
    }
}
