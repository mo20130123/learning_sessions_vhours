<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseProduct extends Model
{
    // protected $table = 'facilities';
    protected $fillable = [
      'category_id', 'name_en','name_ar','icon', 'status','position'
    ];

    public function path()
    {
       return url("BaseProduct/{$this->id}-". Str::slug($this->name??$this->name_en) );
    }





}
