<?php

use Illuminate\Database\Seeder;

class RiskCategorySeed extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $items = [['id'=>1,'sTitle'=>'Policy Development and Advocacy','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Policy Development and Advocacy<\/span><\/p>','created_at'=>'2018-05-15 08:19:52','updated_at'=>'2018-05-15 08:19:52','deleted_at'=>null],['id'=>2,'sTitle'=>'Organizational','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Organizational<\/span><\/p>','created_at'=>'2018-05-15 08:20:01','updated_at'=>'2018-05-15 08:20:01','deleted_at'=>null],['id'=>3,'sTitle'=>'Leadership','sDescription'=>'<p>Leadership<\/p>','created_at'=>'2018-05-15 08:20:14','updated_at'=>'2018-05-15 08:20:14','deleted_at'=>null],['id'=>4,'sTitle'=>'Research and Development','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Research and Development<\/span><\/p>','created_at'=>'2018-05-15 08:20:20','updated_at'=>'2018-05-15 08:20:20','deleted_at'=>null],['id'=>5,'sTitle'=>'Technology Assessment and Transfer','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Technology Assessment and Transfer<\/span><\/p>','created_at'=>'2018-05-15 08:20:28','updated_at'=>'2018-05-15 08:20:28','deleted_at'=>null],['id'=>6,'sTitle'=>'Capability Building and Institutional Building','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Capability Building and Institutional Building<\/span><\/p>','created_at'=>'2018-05-15 08:20:52','updated_at'=>'2018-05-15 08:20:52','deleted_at'=>null],['id'=>7,'sTitle'=>'Finance','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Finance<\/span><\/p>','created_at'=>'2018-05-15 08:21:06','updated_at'=>'2018-05-15 08:21:06','deleted_at'=>null],['id'=>8,'sTitle'=>'Property','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Property<\/span><\/p>','created_at'=>'2018-05-15 08:21:15','updated_at'=>'2018-05-15 08:21:15','deleted_at'=>null],['id'=>9,'sTitle'=>'Human Resource','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Human Resource<\/span><\/p>','created_at'=>'2018-05-15 08:21:28','updated_at'=>'2018-05-15 08:21:28','deleted_at'=>null],['id'=>10,'sTitle'=>'Information Technology','sDescription'=>'<p><span style=\'font-family: arial, sans, sans-serif; font-size: 13px; white-space: pre-wrap;\'>Information Technology<\/span><\/p>','created_at'=>'2018-05-15 08:21:44','updated_at'=>'2018-05-15 08:21:44','deleted_at'=>null]];

        foreach ($items as $item) {
            \App\RiskCategory::create($item);
        }
    }

}
