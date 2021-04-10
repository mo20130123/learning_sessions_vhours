<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductKeywords extends Model
{
    protected $table = 'products_key_words';
    protected $fillable = [
        'product_id', 'name_en', 'name_ar'
    ];

    public function Product()
    {
       return $this->belongsTo(Product::class,'product_id');
    }

}
