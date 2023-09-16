<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan')->insert([
            [
                'name' => 'Básico',
                'cost' => '25',
                'profile' => 'Perfiles de junta (tres cargos)',
                'user' => 'Usuarios según pisos y aptos',
                'email' => 'Correo y Mensajeria 1 administrador',
                'billboard' => 'Cartelera Digital',
            ],
            [
                'name' => 'Empresarial',
                'cost' => '50',
                'profile' => 'Perfiles de junta (tres cargos)',
                'user' => 'Usuarios según pisos y aptos',
                'email' => 'Correo y Mensajeria 1 administrador',
                'billboard' => 'Cartelera Digital',
            ],
            [
                'name' => 'Mixto',
                'cost' => '100',
                'profile' => 'Perfiles de junta (tres cargos)',
                'user' => 'Usuarios según pisos y aptos',
                'email' => 'Correo y Mensajeria 1 administrador',
                'billboard' => 'Cartelera Digital',
            ],
        ]);
    }
}
