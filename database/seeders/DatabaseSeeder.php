<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ModulesSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(RelationRolesModulesSeeder::class);
        $this->call(EntityClassSeed::class);
        $this->call(EntitySubClassSeed::class);
        $this->call(PlanSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ResidentialSeeder::class);
        $this->call(PlanInvoiceSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(BankResidentialSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(PhoneSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(IdentitySeeder::class);
    }
}
