<?php

use Illuminate\Database\Seeder;

class RisksSeed extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $items = [];

        foreach ($items as $item) {
            \App\Risks::create($item);
        }
    }

}
