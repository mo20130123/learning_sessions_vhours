<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedBasketItem extends Model
{
    protected $table = 'saved_basket_items';
    protected $guarded = ['id'];
    public $timestamps = false;
}
