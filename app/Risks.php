<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



use Illuminate\Database\Eloquent\SoftDeletes;

class Risks extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'risks';
    
    protected $fillable = [
          'riskcategory_id',
          'sRiskName',
          'sConsequence',
          'sPotentialCause',
          'risklikelihood_id',
          'riskconsequence_id',
          'riskexposure_id',
          'sEvaluation'
    ];
    


    
    public function riskcategory()
    {
        return $this->hasOne('App\RiskCategory', 'id', 'riskcategory_id');
    }


    public function risklikelihood()
    {
        return $this->hasOne('App\RiskLikelihood', 'id', 'risklikelihood_id');
    }


    public function riskconsequence()
    {
        return $this->hasOne('App\RiskConsequence', 'id', 'riskconsequence_id');
    }


    public function riskexposure()
    {
        return $this->hasOne('App\RiskExposure', 'id', 'riskexposure_id');
    }


    
    
    
}