<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    protected $table = 'privacy_policy';
    protected $guarded = ['id'];

    // public function setTextArAttribute($value)
    // {
    //     if($value && $value!= 'undefined')
    //         $value = addcslashes( $value, "\n");
    //         $value = str_replace( array( '"',  '`' , "'" ), ' ', $value);
    //         $this->attributes['text_ar'] =  addcslashes( $value, "\r" );
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
