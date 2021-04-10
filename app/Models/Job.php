<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'type','title_en','title_ar','description_en','description_ar','status','position','type'
    ];

    public function Requirements()
    {
       return $this->hasMany(JobRequirement::class);
    }

}
