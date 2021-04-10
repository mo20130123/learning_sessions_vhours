<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletPaymets extends Model
{
    protected $table = 'wallet_paymets';

    protected $fillable = [
        'member_id','amount','is_paid','source'
    ];

    const UPDATED_AT = null;


}
