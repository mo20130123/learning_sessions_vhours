<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $guarded = ['id'];
    const UPDATED_AT = null;

    public function getResumeAttribute($value){
         return asset('images/Resume/'.$value);
    }

    public function setResumeAttribute($value)
    {
        if(is_file($value))
        {
           $fileName = 'Resume_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
           $destinationPath = public_path('images/Resume');
           $value->move($destinationPath, $fileName); // uploading file to given path
           $this->attributes['resume'] = $fileName;
        }
    }

}
