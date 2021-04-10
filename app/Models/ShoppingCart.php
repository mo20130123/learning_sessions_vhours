<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use DB;

class ShoppingCart extends Model
{
    protected $table = 'shopping_cart';
    const UPDATED_AT = null;

    protected $guarded = ['id'];

    public static function delete_outOfStock()
    {
       ShoppingCart::leftJoin('products','products.id','shopping_cart.product_id')
                   ->where('products.quantity','<=','0' )
                   ->orWhereNull('products.id')
                   ->groupBy('shopping_cart.id')
                   ->delete();
    }

    public static function CartFULL($AuthMember_id=0,$getAuthMember_id_from_session=true)
    {
      $lang = \App::getLocale();

      if($getAuthMember_id_from_session){
        $AuthMember_id = ( auth('Member')->check() )? auth('Member')->id() : 0 ;
      }
      return  ShoppingCart::select('shopping_cart.id as shopping_cart_id','products.id as id','products.category_id',
                       'shopping_cart.product_id as product_id',
                       "products.name_$lang as name" ,"products.is_available as is_available",
                       "product_images.image as image",'is_bundle','package','marketing_brief_id','brief_text',
                       // DB::raw("GROUP_CONCAT(CONCAT('".asset('images/ProductImages')."/',product_images.image)) as images"),

                     // DB::raw("CONCAT('".url('category')."/',sub_categories.id,'-',sub_categories.name_$lang) as url_sub_cat"),
                     DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
                     "requirements_$lang as requirements",
                     "categories.name_$lang as category_name","base_products.name_$lang as base_product_name",
                       DB::raw("
                            CASE
                              WHEN package = 'Standard' THEN product_package_standard.price
                              WHEN package = 'Basic' THEN product_package_basic.price
                              WHEN package = 'Premium' THEN product_package_premium.price
                            END as price
                       "),
                       DB::raw("0 as show_delete_dialog")
                  )
             ->groupBy('shopping_cart.id')
             ->leftJoin('products',function($q)use($AuthMember_id){
                $q->on('shopping_cart.product_id','products.id');
             })
             ->leftJoin('product_images',function($q){
                 $q->on('product_images.product_id','products.id')->where('product_images.is_main',1);
             })
             ->leftJoin('categories','categories.id','products.category_id')
             ->leftJoin('base_products','base_products.id','products.base_product_id')

             ->leftJoin('product_package_standard','product_package_standard.product_id','products.id')
             ->leftJoin('product_package_basic','product_package_basic.product_id','products.id')
             ->leftJoin('product_package_premium','product_package_premium.product_id','products.id')
             ->where('shopping_cart.member_id',$AuthMember_id)
             // ->leftJoin('sub_categories','sub_categories.id','products.sub_category_id')
             ->where('products.status',1);
    }

    public static function CartFULLGuest($products_ids,$type=null)
    {
      $lang = \App::getLocale();
      $select_columns = ['products.id as id','products.category_id',
                       "products.name_$lang as name" ,
                       "products.short_description_$lang as short_description",
                       'products.price',"products.old_price as old_price","products.discount_percentage as discount_percentage",
                       "product_images.image as image",
                       'is_chef_rec', "products.quantity as quantity",
                       DB::raw("if( products.discount_percentage > 0 , 1,0 ) as is_discount"),
                       DB::raw("if( date_add(products.created_at,INTERVAL 1 MONTH) > NOW() , 1,0 ) as is_new"),
                     DB::raw("1 as in_card"),
                     DB::raw("0 as in_wish_list"),
                     DB::raw("1 as in_card_quantity"),
                     'is_bundle','bundle_products_ids',"bundle_summary_$lang as bundle_label"];
         return  Product::select($select_columns)
              ->groupBy('products.id')
              ->leftJoin('product_images',function($q){
                  $q->on('product_images.product_id','products.id')->where('product_images.is_main',1);
              })
              ->where('products.status',1)
              ->whereIn('products.id',$products_ids)
              ->where(function($q)use($type){
                  if($type=='bundle')
                    $q->where('products.is_bundle',1);
                  else if($type=='product')
                    $q->where('products.is_bundle',0);
               })
              ->limit(200) ;
    }

    public function getImagesAttribute($value){
         if($value)
         return explode(',', $value) ;
    }

    public function getImageAttribute($value){
         if($value)
           return asset('images/ProductImages/'.$value);
    }
}
