<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateRisksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('risks',function(Blueprint $table){
            $table->increments("id");
            $table->integer("riskcategory_id")->references("id")->on("riskcategory");
            $table->string("sRiskName");
            $table->text("sConsequence");
            $table->text("sPotentialCause");
            $table->integer("risklikelihood_id")->references("id")->on("risklikelihood");
            $table->integer("riskconsequence_id")->references("id")->on("riskconsequence");
            $table->integer("riskexposure_id")->references("id")->on("riskexposure");
            $table->text("sEvaluation")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('risks');
    }

}