<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsAndConditions extends Model
{
    protected $table = 'terms_and_conditions';
    protected $guarded = ['id'];



    // public function setTextArAttribute($value)
    // {
    //     if($value && $value!= 'undefined')
    //       $value = addcslashes( $value, "\n");
    //       $value = str_replace( array( '"',  '`' , "'" ), ' ', $value);
    //       $this->attributes['text_ar'] =  addcslashes( $value, "\r" );
    // }
    //
    // public function setTextEnAttribute($value)
    // {
    //     if($value && $value!= 'undefined')
    //       $value = addcslashes( $value, "\n");
    //       $value = str_replace( array( '"',  '`' , "'" ), ' ', $value);
    //       $this->attributes['text_en'] =  addcslashes( $value, "\r" );
    // }

}
