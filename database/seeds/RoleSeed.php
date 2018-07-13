<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $items = [['id'=>1,'title'=>'Administrator','created_at'=>'2017-10-28 04:05:04','updated_at'=>'2017-10-28 04:05:04'],['id'=>2,'title'=>'User','created_at'=>'2017-10-28 04:05:04','updated_at'=>'2017-10-28 04:05:04'],['id'=>3,'title'=>'addsfd','created_at'=>'2018-04-16 08:05:53','updated_at'=>'2018-04-16 08:05:53']];

        foreach ($items as $item) {
            \App\Role::create($item);
        }
    }

}
