<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



use Illuminate\Database\Eloquent\SoftDeletes;

class Responsibility extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'responsibility';
    
    protected $fillable = [
          'sTitle',
          'sDescription'
    ];
    


    
    
    
    
}