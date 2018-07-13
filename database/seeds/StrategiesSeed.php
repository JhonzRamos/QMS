<?php

use Illuminate\Database\Seeder;

class StrategiesSeed extends Seeder
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
            \App\Strategies::create($item);
        }
    }

}
