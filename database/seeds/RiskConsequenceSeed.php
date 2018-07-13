<?php

use Illuminate\Database\Seeder;

class RiskConsequenceSeed extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $items = [['id'=>1,'sTitle'=>'MINOR','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Some impact that is easily remedied.<\/span><\/p>','created_at'=>'2018-05-15 08:23:28','updated_at'=>'2018-05-16 06:23:29','deleted_at'=>null],['id'=>2,'sTitle'=>'MAJOR','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Material impact on Practice\/Firm. Key business objectives not achieved<\/span><\/p>','created_at'=>'2018-05-15 08:23:37','updated_at'=>'2018-05-16 06:23:54','deleted_at'=>null],['id'=>3,'sTitle'=>'CATASTHROPIC','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Could shut down Practice\/part of Firm. Business objectives not achieved<\/span><\/p>','created_at'=>'2018-05-15 08:23:48','updated_at'=>'2018-05-16 06:24:44','deleted_at'=>null],['id'=>4,'sTitle'=>'INSIGNIFICANT','sDescription'=>'<p>Impact not visible.<\/p>','created_at'=>'2018-05-15 08:27:08','updated_at'=>'2018-05-16 06:23:37','deleted_at'=>null],['id'=>5,'sTitle'=>'MODERATE','sDescription'=>'<p>Noticeable impact on Practice\/Firm.<\/p>\r\n<p>Some business objectives not achieved<\/p>','created_at'=>'2018-05-16 06:23:17','updated_at'=>'2018-05-16 06:24:06','deleted_at'=>null]];

        foreach ($items as $item) {
            \App\RiskConsequence::create($item);
        }
    }

}
