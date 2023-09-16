<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PlanInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('planInvoice')->insert([
            [
                'idUser' => 1,
                'idPlan' => 1,
                'idTime' => 70,
                'paymentDate' => '2023-03-13 18:11:05',
                'amount' => 25.00,
                'idBank' => 7,
                'referenceNumber' => '111222333',
                'pathArchive' => '',
            ],

        ]);
    }
}
