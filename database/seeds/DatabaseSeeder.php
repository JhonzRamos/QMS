<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        //$this->call(RoleSeed::class);
        //$this->call(UserSeed::class);
        $this->call(RiskTreatmentOptionsSeed::class);
        $this->call(RiskLikelihoodSeed::class);
        $this->call(RiskConsequenceSeed::class);
        $this->call(RiskExposureSeed::class);
        $this->call(ResponsibilitySeed::class);
        $this->call(RiskCategorySeed::class);
        $this->call(RisksSeed::class);
        $this->call(StrategiesSeed::class);
        $this->call(RoleSeed::class);
        $this->call(UserSeed::class);

    }
}