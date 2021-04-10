<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsObjectives extends Model
{
    protected $table = 'ads_objectives';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function Products()
    {
       return $this->hasMany('App\Models\AdsProducts','ads_objective_id')->orderBy('position');
    }

}
