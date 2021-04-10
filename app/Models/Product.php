<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;
class Product extends Model
{
    protected $fillable = [
        'category_id','base_product_id','provider_id',
        'name_en','name_ar' ,
        'short_description_en','short_description_ar','selles_times_no',
        'rate','youtube_link','is_available','is_bundle','position','status','offer_percentage',
        'description_en','description_ar',
        'requirements_en','requirements_ar',
        'Pakage_Basic_items_en','Pakage_Standard_items_en','Pakage_Premium_items_en',
        'Pakage_Basic_items_ar','Pakage_Standard_items_ar','Pakage_Premium_items_ar',
        'have_BasicPakage','have_StandardPakage','have_PremiumPakage'
    ];

    protected $casts = [
       'is_available' => 'boolean',
    ];


    public static function productsMinimal($AuthMember_id=0,$extra_cols=null)
    {
      $AuthMember_id = auth('Member')->id();
      $lang = \App::getLocale();
      $select_columns = [
                         'products.id as id','products.category_id','products.base_product_id',
                         "products.name_$lang as name" , 'products.offer_percentage',
                         "products.short_description_$lang as short_description",
                         "product_images.image as image", 'is_bundle' ,'products.is_available',
                       // DB::raw("if( date_add(products.created_at,INTERVAL 1 MONTH) > NOW() , 1,0 ) as is_new"),
                          DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
                          DB::raw("if( wish_list.product_id , 1,0 ) as in_wish_list"),
                          DB::raw( "CONCAT('".url('')."/product/',products.id,'-', REPLACE(products.name_en, ' ', '_') )" . " as path" ),
                        ];
          if($extra_cols){
             $select_columns = array_merge($select_columns,$extra_cols);
          }

          return self::productsQuery($AuthMember_id,$select_columns);
    }

    public static function BundleMinimal($AuthMember_id=0,$extra_cols=null)
    {
      $lang = \App::getLocale();
      $select_columns = [
                         'products.id as id','products.category_id','products.base_product_id',
                         "products.name_$lang as name" , 'products.offer_percentage',
                         "products.short_description_$lang as short_description",
                         "product_images.image as image", 'is_bundle' ,'products.is_available',
                       // DB::raw("if( date_add(products.created_at,INTERVAL 1 MONTH) > NOW() , 1,0 ) as is_new"),
                          DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
                          DB::raw("if( wish_list.product_id , 1,0 ) as in_wish_list"),
                          DB::raw("GROUP_CONCAT(CONCAT('".asset('images/ProductImages')."/',product_images.image)) as images"),
                          DB::raw( "CONCAT('".url('')."/product/',products.id,'-', REPLACE(products.name_en, ' ', '_') )" . " as path" )
                       ];
          // if($extra_cols){
          //    $select_columns = array_merge($select_columns,$extra_cols);
          // }

          return self::BundleQuery($AuthMember_id,$select_columns);
    }

    public static function productsQuery($AuthMember_id,$select_columns)
    {

        return  Product::select($select_columns)
             ->groupBy('products.id')
             ->leftJoin('product_images',function($q){
                 $q->on('product_images.product_id','products.id')->where('product_images.is_main',1);
             })
             ->leftJoin('shopping_cart',function($q)use($AuthMember_id){
                 $q->on('shopping_cart.product_id','products.id')->where('shopping_cart.member_id',$AuthMember_id);
             })
             ->leftJoin('wish_list',function($q)use($AuthMember_id){
                 $q->on('wish_list.product_id','products.id')->where('wish_list.member_id',$AuthMember_id);
             })
             ->where('products.status',1);
    }

    public static function BundleQuery($AuthMember_id,$select_columns)
    {
        return  Product::select($select_columns)
             ->groupBy('products.id')
             ->leftJoin('product_images',function($q){
                 $q->on('product_images.product_id','products.id');
             })
             ->leftJoin('shopping_cart',function($q)use($AuthMember_id){
                 $q->on('shopping_cart.product_id','products.id')->where('shopping_cart.member_id',$AuthMember_id);
             })
             ->leftJoin('wish_list',function($q)use($AuthMember_id){
                 $q->on('wish_list.product_id','products.id')->where('wish_list.member_id',$AuthMember_id);
             })
             ->where('products.status',1)
             ->where('is_bundle',1);
    }

    public function path()
    {
       return url("product/{$this->id}-". Str::slug($this->name??$this->name_en) );
    }

    public function Provider()
    {
       $lang = \App::getLocale();
        return $this->belongsto('App\Models\Provider','provider_id')
                    ->select('*',"name_$lang as name" );
    }

    public function PackageBasic()
    {
        $lang = \App::getLocale();
        return $this->hasOne('App\Models\ProductPackageBasic','product_id')
                    ->select('*',"remaining_text_$lang as remaining_text");
    }

    public function PackageStandard()
    {
        $lang = \App::getLocale();
        return $this->hasOne('App\Models\ProductPackageStandard','product_id')
                    ->select('*',"remaining_text_$lang as remaining_text");
    }

    public function PackagePremium()
    {
        $lang = \App::getLocale();
        return $this->hasOne('App\Models\ProductPackagePremium','product_id')
                    ->select('*',"remaining_text_$lang as remaining_text");
    }

    public function PackageBundle()
    {
        $lang = \App::getLocale();
        return $this->hasOne('App\Models\ProductPackageBundle','product_id')
                    ->select('*',"remaining_text_$lang as remaining_text");
    }

    public function Images()
    {
        return $this->hasMany('App\Models\ProductImages');
    }

    public function Category()
    {
        return $this->belongsto('App\Models\Category','category_id');
    }
    public function BaseProduct()
    {
        return $this->belongsto('App\Models\BaseProduct','base_product_id');
    }


    public function Keywords()
    {
        return $this->hasMany('App\Models\ProductKeywords');
    }

    public function getImageAttribute($value){
         if($value)
           return asset('images/ProductImages/'.$value);
    }

    public function setNameArAttribute($value)
    {
        if($value && $value!= 'undefined'){
          $value = addcslashes( $value, "\n");
          $value = str_replace( array( '"',  '`' , "'" ), ' ', $value);
          $this->attributes['name_ar'] =  addcslashes( $value, "\r" );
        }
    }

    public function setNameEnAttribute($value)
    {
        if($value && $value!= 'undefined'){
          $value = addcslashes( $value, "\n");
          $value = str_replace( array( '"',  '`' , "'" ), ' ', $value);
          $this->attributes['name_en'] =  addcslashes( $value, "\r" );
        }
    }

    // public function setDescriptionArAttribute($value)
    // {
    //     if($value && $value!= 'undefined'){
    //       $value = addcslashes( $value, "\n");
    //       $value = str_replace( array( '"',  '`' , "'" ), ' ', $value);
    //       $this->attributes['description_ar'] =  addcslashes( $value, "\r" );
    //     }
    // }
    //
    // public function setDescriptionEnAttribute($value)
    // {
    //     if($value && $value!= 'undefined'){
    //       $value = addcslashes( $value, "\n");
    //       $value = str_replace( array( '"',  '`' , "'" ), ' ', $value);
    //       $this->attributes['description_en'] =  addcslashes( $value, "\r" );
    //     }
    // }

    public function setShortDescriptionArAttribute($value)
    {
        if($value == 'null' || $value == 'undefined')
          $this->attributes['short_description_ar'] = null;
        else
          $this->attributes['short_description_ar'] = $value;
    }

    public function setShortDescriptionEnAttribute($value)
    {
        if($value == 'null' || $value == 'undefined')
          $this->attributes['short_description_en'] = null;
        else
          $this->attributes['short_description_en'] = $value;
    }


}
