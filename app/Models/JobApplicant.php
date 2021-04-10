<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplicant extends Model
{
    protected $table = 'job_applicants';
    const UPDATED_AT = null;

   protected $guarded = ['id'];

    public function getResumeAttribute($value){
        return asset('images/resume/'.$value);
    }

     public function setResumeAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'Resume_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/resume');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['resume'] = $fileName;
         }
     }


}
