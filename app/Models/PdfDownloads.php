<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PdfDownloads extends Model
{
    protected $table = 'pdf_downloads';
    protected $fillable = [
        'pdf','name_en', 'name_ar','status'
    ];

    public function getPdfAttribute($value){
        return asset('images/PdfDownloads/'.$value);
    }

     public function setPdfAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'PdfDownloads_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/PdfDownloads');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['pdf'] = $fileName;
         }
     }

}
