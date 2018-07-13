<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



use Illuminate\Database\Eloquent\SoftDeletes;

class RiskConsequence extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'riskconsequence';
    
    protected $fillable = [
          'sTitle',
          'sDescription'
    ];
    


    
    
    
    
}