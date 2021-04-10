<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedBasket extends Model
{
    protected $table = 'saved_baskets';
    protected $guarded = ['id'];
    const UPDATED_AT = null;
}
