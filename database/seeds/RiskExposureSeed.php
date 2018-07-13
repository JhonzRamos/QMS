<?php

use Illuminate\Database\Seeder;

class RiskExposureSeed extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $items = [['id'=>1,'sTitle'=>'VERY LOW','sDescription'=>'<p>VERY LOW<\/p>','sBackgroundColor'=>'#078c04','created_at'=>'2018-05-16 06:28:21','updated_at'=>'2018-05-16 06:28:21','deleted_at'=>null],['id'=>2,'sTitle'=>'LOW','sDescription'=>'<p>LOW<\/p>','sBackgroundColor'=>'#84ad0e','created_at'=>'2018-05-16 06:28:44','updated_at'=>'2018-05-16 06:28:44','deleted_at'=>null],['id'=>3,'sTitle'=>'TOLERABLE','sDescription'=>'<p>TOLERABLE<\/p>','sBackgroundColor'=>'#dbed07','created_at'=>'2018-05-16 06:29:04','updated_at'=>'2018-05-16 06:29:04','deleted_at'=>null],['id'=>4,'sTitle'=>'HIGH','sDescription'=>'<p>HIGH<\/p>','sBackgroundColor'=>'#fc6b03','created_at'=>'2018-05-16 06:29:27','updated_at'=>'2018-05-16 06:29:27','deleted_at'=>null],['id'=>5,'sTitle'=>'VERY HIGH','sDescription'=>'<p>VERY HIGH<\/p>','sBackgroundColor'=>'#ff0000','created_at'=>'2018-05-16 06:29:44','updated_at'=>'2018-05-16 06:29:44','deleted_at'=>null]];

        foreach ($items as $item) {
            \App\RiskExposure::create($item);
        }
    }

}
