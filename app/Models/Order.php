<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ProductPackageBasic;
use App\Models\ProductPackageStandard;
use App\Models\ProductPackagePremium;

class Order extends Model
{
    // protected $table = 'promo_codes';
    const UPDATED_AT = null;

    protected $fillable = [
        'member_id','total_price', 'points_deduction_price' ,'discount_percentage','vat_price',
        'wallet_deduction', 'final_price','is_piad','delivery_status','payment_method','is_init_for_card_payment',
        'security_code'
    ];

    public function Products()
    {
        return $this->hasMany('App\Product');
    }

    public function Member()
    {
        return $this->belongsTo('App\Member','member_id');
    }

    public static function get_product_price($pakage_type,$product_id)
    {
          switch ($pakage_type)
          {
              case 'Basic':
                  $price = ProductPackageBasic::select('price')->where('product_id',$product_id)->first();
                break;
              case 'Standard':
                  $price = ProductPackageStandard::select('price')->where('product_id',$product_id)->first();
                break;
              case 'Premium':
                  $price = ProductPackagePremium::select('price')->where('product_id',$product_id)->first();
                break;
              case 'Bundle':
                  $price = ProductPackageBundle::select('price')->where('product_id',$product_id)->first();
                break;
          }

          if($price)
            { $price = $price->price; }
          else
            { $price = 0; }

          return $price;
    }

}
