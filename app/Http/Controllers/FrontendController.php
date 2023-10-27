<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Size;
use App\Models\Thumbnail;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function index(){
        $categories = Category::all();
        $products = Product::all();
        $recentproducts = Product::latest()->take(3)->get();
        $top_selling_product = OrderProduct::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->havingRaw('sum >= 5')
        ->take(3)
        ->orderBy('sum', 'DESC')
        ->get();
        return view('frontend.index', [
            'categories'=> $categories,
            'products'=> $products,
            'recentproducts'=> $recentproducts,
            'top_selling_product'=> $top_selling_product,
        ]);
    }

    function product_details($slug){
        $product_id = Product::where('slug', $slug)->first()->id;
        $product_info = Product::find($product_id);
        $related_products = Product::where('category_id', $product_info->category_id)->where('id', '!=', $product_id)->get();
        $thumbnails = Thumbnail::where('product_id', $product_id)->get();
        $available_colors = Inventory::where('product_id', $product_id)
        ->groupBy('color_id')
        ->selectRaw('count(*) as total, color_id')
        ->get();
        $available_sizes = Inventory::where('product_id', $product_id)
        ->groupBy('size_id')
        ->selectRaw('count(*) as total, size_id')
        ->get();
        $product_reviews = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->latest()->get();
        $total_review = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->count();
        $total_star = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->sum('star');
        return view('frontend.product_details', [
            'product_info'=> $product_info,
            'related_products'=> $related_products,
            'thumbnails'=> $thumbnails,
            'available_colors'=> $available_colors,
            'available_sizes'=> $available_sizes,
            'product_reviews'=> $product_reviews,
            'total_review'=> $total_review,
            'total_star'=> $total_star,
        ]);
    }

    function getSize(Request $request){
        $str = '';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach($sizes as $size){
            if($size->size_id == 1){
                $str .= '<div class="form-check form-option form-check-inline mb-2">
                    <input checked class="form-check-input" type="radio" name="size_id" id="size' . $size->size_id . ' }}" value="' . $size->size_id . '">
                    <label class="form-option-label" for="size' . $size->size_id . ' }}">' . $size->rel_to_size->size_name . '</label>
                </div>';
            }
            else{
                $str .= '<div class="form-check form-option form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="size_id" id="size' . $size->size_id . ' }}" value="' . $size->size_id . '">
                    <label class="form-option-label" for="size' . $size->size_id . ' }}">' . $size->rel_to_size->size_name . '</label>
                </div>';
            }

        }
        echo $str;
    }

    function customer_login_register(){
        return view('frontend.customer_log_register');
    }

    function shop(Request $request){
        $data = $request->all();

        $sorting = 'created_at';
        $type = 'DESC';

        if(!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined'){
            if($data['sort'] == 1){
                $sorting = 'after_discount';
                $type = 'ASC';
            }
            else if($data['sort'] == 2){
                $sorting = 'after_discount';
                $type = 'DESC';
            }
            else if($data['sort'] == 3){
                $sorting = 'product_name';
                $type = 'ASC';
            }
            else if($data['sort'] == 4){
                $sorting = 'product_name';
                $type = 'DESC';
            }
        }



        $searched_product = Product::where(function ($q) use ($data){
        $min = 0;
        if (!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined') {
            $min = $data['min'];
        } else {
            $min = 1;
        }

            if(!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined'){
                $q->where(function($q) use ($data){
                    $q->where('product_name', 'like', '%'.$data['q'].'%');
                    $q->Orwhere('short_desp', 'like', '%'.$data['q'].'%');
                    $q->Orwhere('long_desp', 'like', '%'.$data['q'].'%');
                });
            }
            if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined'){
                $q->where(function($q) use ($data){
                    $q->where('category_id', $data['category_id']);
                });
            }
            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                $q->whereBetween('after_discount', [$min, $data['max']]);
            }
            if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                $q->whereHas('rel_to_inventory', function($q) use ($data){
                    if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                        $q->whereHas('rel_to_color', function($q) use ($data){
                            $q->where('colors.id', $data['color_id']);
                        });
                    }
                    if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                        $q->whereHas('rel_to_size', function($q) use ($data){
                            $q->where('sizes.id', $data['size_id']);
                        });
                    }
                });
            }
        })->orderBy($sorting, $type)->get();

        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('frontend.shop', [
            'searched_product'=> $searched_product,
            'categories'=> $categories,
            'colors'=> $colors,
            'sizes'=> $sizes,
        ]);
    }
}
