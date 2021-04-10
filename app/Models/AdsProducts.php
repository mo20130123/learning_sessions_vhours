<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsProducts extends Model
{
    protected $table = 'ads_products';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function Products()
    {
       return $this->belongsTo('App\Models\AdsObjectives','ads_objective_id','id');
    }

    public function Images()
    {
        return $this->hasMany('App\Models\AdProductImages','ads_product_id');
    }


}
