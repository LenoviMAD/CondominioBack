<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mParish')->insert([
            ['id' => 1, 'idCity' => "2808", 'name' => "23 de Enero"],
            ['id' => 2, 'idCity' => "2808", 'name' => "Altagracia"],
            ['id' => 3, 'idCity' => "2808", 'name' => "AntÃ­mano"],
            ['id' => 4, 'idCity' => "2808", 'name' => "La Candelaria"],
            ['id' => 5, 'idCity' => "2808", 'name' => "Caricuao"],
            ['id' => 6, 'idCity' => "2808", 'name' => "Catedral"],
            ['id' => 7, 'idCity' => "2808", 'name' => "Coche"],
            ['id' => 8, 'idCity' => "2808", 'name' => "El Junquito"],
            ['id' => 9, 'idCity' => "2808", 'name' => "El ParaÃ­so"],
            ['id' => 10, 'idCity' => "2808", 'name' => "El Recreo"],
            ['id' => 11, 'idCity' => "2808", 'name' => "El Valle"],
            ['id' => 12, 'idCity' => "2808", 'name' => "La Pastora"],
            ['id' => 13, 'idCity' => "2808", 'name' => "La Vega"],
            ['id' => 14, 'idCity' => "2808", 'name' => "Macarao"],
            ['id' => 15, 'idCity' => "2808", 'name' => "San JosÃ©"],
            ['id' => 16, 'idCity' => "2808", 'name' => "San AgustÃ­n"],
            ['id' => 17, 'idCity' => "2808", 'name' => "San Bernardino"],
            ['id' => 18, 'idCity' => "2808", 'name' => "San Juan"],
            ['id' => 19, 'idCity' => "2808", 'name' => "San Pedro"],
            ['id' => 20, 'idCity' => "2808", 'name' => "Santa RosalÃ­a"],
            ['id' => 21, 'idCity' => "2808", 'name' => "Santa Teresa"],
            ['id' => 22, 'idCity' => "2808", 'name' => "Sucre"],

        ]);
    }
}
