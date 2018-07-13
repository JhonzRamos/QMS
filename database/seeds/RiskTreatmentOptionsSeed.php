<?php

use Illuminate\Database\Seeder;

class RiskTreatmentOptionsSeed extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $items = [['id'=>1,'sROTitle'=>'REDUCE','sRODescription'=>'<p><span style=\'font-family: arial, sans, sans-serif;\'><span style=\'font-size: 13px; white-space: pre-wrap;\'>Implementing a strategy that is designed to reduce the likelihood or consequence of the risk to an acceptable level, where elimination is considered to be excessive in terms of time or expense <\/span><\/span><\/p>','created_at'=>'2018-05-15 08:24:53','updated_at'=>'2018-05-16 06:16:59','deleted_at'=>null],['id'=>2,'sROTitle'=>'ACCEPT','sRODescription'=>'<p>Making an informed decision that the risk rating is at an acceptable level or that the cost of the treatment outweighs the benefit. This option may also be relevant in situations where a residual risk remains after other treatment options have been put in place. No further action is taken to treat the risk, however, ongoing monitoring is recommended.<\/p>\r\n<p>&nbsp;<\/p>','created_at'=>'2018-05-15 08:25:05','updated_at'=>'2018-05-16 06:17:35','deleted_at'=>null],['id'=>3,'sROTitle'=>'TRANSFER','sRODescription'=>'<p>Implementing a strategy that shares or transfers the risk to another party or parties, such as outsourcing the management of physical assets, developing contracts with service providers or insuring against the risk. The third-party accepting the risk should be aware of and agree to accept this obligation.<\/p>\r\n<p>&nbsp;<\/p>','created_at'=>'2018-05-15 08:25:13','updated_at'=>'2018-05-16 06:17:16','deleted_at'=>null],['id'=>4,'sROTitle'=>'AVOID','sRODescription'=>'<p>Deciding not to proceed with the activity that introduced the unacceptable risk, choosing an alternative more acceptable activity that meets business objectives, or choosing an alternative less risky approach or process.<\/p>\r\n<p>&nbsp;<\/p>','created_at'=>'2018-05-15 08:25:33','updated_at'=>'2018-05-16 06:16:30','deleted_at'=>null]];

        foreach ($items as $item) {
            \App\RiskTreatmentOptions::create($item);
        }
    }

}
