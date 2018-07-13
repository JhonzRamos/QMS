<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $items = [['id'=>1,'role_id'=>1,'name'=>'Admin','email'=>'admin@example.com','password'=>'$2y$10$75z0mTJbiCJy89GTe6csheSMxdSm6L9\/u1CWngUgh8Ifkd0zKmINi','remember_token'=>'5s97VWFvdlkqb4riWz8DVdRNSYMRNYoQMS3Y9RQoe5qrwKMDk3DU1jSLNwE6','created_at'=>'2017-10-28 04:05:21','updated_at'=>'2017-10-28 04:05:21'],['id'=>2,'role_id'=>1,'name'=>'Super Admin','email'=>'elowie.cruz@gmail.com','password'=>'$2y$10$lMBwWMxp5.wN1lQ\/659lfepBRTZuOQCIyFnwMXo9MmeHOFqkLPhIm','remember_token'=>'HntVktUTT8MCYlHO15gL7qT2Zum19BetDtuz26YZK0gaZblTdKlIaJQQzlOi','created_at'=>'2018-04-09 08:10:52','updated_at'=>'2018-04-17 08:53:10'],['id'=>3,'role_id'=>2,'name'=>'Client','email'=>'client@example.com','password'=>'$2y$10$fUmJRpiVokP6.\/m.IooZjul.gxkIQJ8J7deLKPZLfEFqeAviBFhc6','remember_token'=>'2rOwAq0wICZC2BbGZrM8F9j9Rx2Z5H0ntfey1pt5Z4UudyZlsheHRQsti3Vq','created_at'=>'2018-04-09 08:55:35','updated_at'=>'2018-05-15 06:33:17']];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }

}
