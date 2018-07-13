<?php

use Illuminate\Database\Seeder;

class ResponsibilitySeed extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $items = [['id'=>1,'sTitle'=>'PCMD','sDescription'=>'<p>PCMD<\/p>','created_at'=>'2018-05-15 08:27:35','updated_at'=>'2018-05-15 08:27:35','deleted_at'=>null],['id'=>2,'sTitle'=>'PCMD-ITMU','sDescription'=>'<p>PCMD-ITMU<\/p>','created_at'=>'2018-05-15 08:27:50','updated_at'=>'2018-05-15 08:27:50','deleted_at'=>null],['id'=>3,'sTitle'=>'OED-IG','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>OED-IG<\/span><\/p>','created_at'=>'2018-05-15 08:27:57','updated_at'=>'2018-05-15 08:27:57','deleted_at'=>null],['id'=>4,'sTitle'=>'OED','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>OED<\/span><\/p>','created_at'=>'2018-05-15 08:28:06','updated_at'=>'2018-05-15 08:28:06','deleted_at'=>null],['id'=>5,'sTitle'=>'HRIDD','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>HRIDD<\/span><\/p>','created_at'=>'2018-05-15 08:28:15','updated_at'=>'2018-05-15 08:28:15','deleted_at'=>null],['id'=>6,'sTitle'=>'FAD','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>FAD<\/span><\/p>','created_at'=>'2018-05-15 08:28:23','updated_at'=>'2018-05-15 08:28:23','deleted_at'=>null],['id'=>7,'sTitle'=>'FAD-Property','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>FAD-Property<\/span><\/p>','created_at'=>'2018-05-15 08:28:36','updated_at'=>'2018-05-15 08:28:36','deleted_at'=>null],['id'=>8,'sTitle'=>'FAD-HR','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>FAD-HR<\/span><\/p>','created_at'=>'2018-05-15 08:28:48','updated_at'=>'2018-05-15 08:28:48','deleted_at'=>null],['id'=>9,'sTitle'=>'RITTD','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>RITTD<\/span><\/p>','created_at'=>'2018-05-15 08:29:09','updated_at'=>'2018-05-15 08:29:09','deleted_at'=>null],['id'=>10,'sTitle'=>'R&D Divisions','sDescription'=>'<p style=\'text-align: left;\'><span style=\'font-family: Arial;\'><span style=\'font-size: 13px; white-space: pre-wrap;\'>R&amp;D Divisions<\/span><\/span><\/p>','created_at'=>'2018-05-15 08:29:34','updated_at'=>'2018-05-15 08:29:34','deleted_at'=>null],['id'=>11,'sTitle'=>'EUSTDD','sDescription'=>'<p style=\'text-align: left;\'><span style=\'font-family: Arial;\'><span style=\'font-size: 13px; white-space: pre-wrap;\'>EUSTDD<\/span><\/span><\/p>','created_at'=>'2018-05-15 08:29:47','updated_at'=>'2018-05-15 08:29:47','deleted_at'=>null],['id'=>12,'sTitle'=>'ITDD','sDescription'=>'<p>ITDD<\/p>','created_at'=>'2018-05-15 08:30:03','updated_at'=>'2018-05-15 08:30:03','deleted_at'=>null],['id'=>13,'sTitle'=>'ETDD','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>ETDD<\/span><\/p>','created_at'=>'2018-05-15 08:30:14','updated_at'=>'2018-05-15 08:30:14','deleted_at'=>null],['id'=>14,'sTitle'=>'Top Management','sDescription'=>'<p>Top Management<\/p>','created_at'=>'2018-05-15 08:30:54','updated_at'=>'2018-05-15 08:30:54','deleted_at'=>null],['id'=>15,'sTitle'=>'Accounting','sDescription'=>'<p style=\'text-align: left;\'><span style=\'font-family: Arial;\'><span style=\'font-size: 13px; white-space: pre-wrap;\'>Accounting<\/span><\/span><\/p>','created_at'=>'2018-05-15 08:31:07','updated_at'=>'2018-05-15 08:31:07','deleted_at'=>null]];

        foreach ($items as $item) {
            \App\Responsibility::create($item);
        }
    }

}
