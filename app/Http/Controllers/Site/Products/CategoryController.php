<?php

namespace App\Http\Controllers\Site\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\Category;
use \App\Models\Product;

class CategoryController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:Member');
    }

    public function index($cat_id)
    {
        $lang = \App::getLocale();
        $Category = Category::select('*',"name_$lang as name")->where('status',1)->findOrFail($cat_id);

        return view('Site.products.Cat_products_list',compact('Category'));
    }

    /*
     * Api
     * Post
     * Get list of products by categoiry_id
     */
    public function list_products_by_categoiry_id(Request $request)
    {
        $cat_id = $request->category_id;

        $lang = \App::getLocale();
        $Products = Product::productsMinimal()
                           ->where('category_id',$cat_id)
                           ->where('is_bundle',0)
                           ->orderBy('position')
                           ->paginate(25);

        return $Products;
    }

}
