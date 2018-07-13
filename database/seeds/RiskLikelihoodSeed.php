<?php

use Illuminate\Database\Seeder;

class RiskLikelihoodSeed extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $items = [['id'=>1,'sTitle'=>'RARE','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Might occur once in 10 years<\/span><\/p>','created_at'=>'2018-05-15 08:22:20','updated_at'=>'2018-05-16 06:20:10','deleted_at'=>null],['id'=>2,'sTitle'=>'POSSIBLE','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Possibly occur once every few years<\/span><\/p>','created_at'=>'2018-05-15 08:22:27','updated_at'=>'2018-05-16 06:20:30','deleted_at'=>null],['id'=>3,'sTitle'=>'ALMOST CERTAIN','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Likely to occur several times a year<\/span><\/p>','created_at'=>'2018-05-15 08:22:39','updated_at'=>'2018-05-16 06:20:53','deleted_at'=>null],['id'=>4,'sTitle'=>'LIKELY','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Likely to occur once a year<\/span><\/p>','created_at'=>'2018-05-15 08:22:50','updated_at'=>'2018-05-16 06:20:43','deleted_at'=>null],['id'=>5,'sTitle'=>'UNLIKELY','sDescription'=>'<p>Maybe occur once in 5 years<\/p>','created_at'=>'2018-05-16 06:19:15','updated_at'=>'2018-05-16 06:19:15','deleted_at'=>null]];

        foreach ($items as $item) {
            \App\RiskLikelihood::create($item);
        }
    }

}
