<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Image;

class ProductController extends Controller
{
    function add_product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.product.add_product', [
            'categories'=> $categories,
            'subcategories'=> $subcategories,
        ]);
    }

    function getSubcategory(Request $request){
       $str = '';
       $subcategory = Subcategory::where('category_id', $request->category_id)->get();
       foreach($subcategory as $sub){
        $str .= '<option value="'. $sub->id.'">'. $sub->subcategory_name.'</option>';
       }
       echo $str;
    }

    function product_store(Request $request){
        $category_name = Category::find($request->category_id);
        $after_discount = $request->price - $request->price* $request->discount/100;
        $slug = Str::lower(str_replace(' ', '-', $request->product_name)).'-'.random_int(1000000, 969696969);
        $sku = $category_name->category_name.'-'.random_int(1000000, 969696969);

        $preview_image = $request->preview;
        $extension = $preview_image->extension();
        $file_name = Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . random_int(10000, 96969).'.'. $extension;
        Image::make($preview_image)->save(public_path('uploads/product/preview/'.$file_name));


        $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'product_name'=>$request->product_name,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'after_discount'=> $after_discount,
            'brand'=> $request->brand,
            'short_desp'=> $request->short_desp,
            'long_desp'=> $request->long_desp,
            'additional_info'=> $request->additional,
            'slug'=>$slug,
            'sku'=> $sku,
            'preview'=> $file_name,
            'created_at'=> Carbon::now(),
        ]);

        if($request->thumbnail != ''){
            foreach($request->thumbnail as $thumbnail){
                $extension = $thumbnail->extension();
                $thumb_name = Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . random_int(10000, 96969) . '.' . $extension;
                Image::make($thumbnail)->save(public_path('uploads/product/thumbnail/'.$thumb_name));
                Thumbnail::insert([
                    'product_id'=> $product_id,
                    'thumbnail'=> $thumb_name,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        return back();
    }

    function product_list(){
        $products = Product::all();
        return view('admin.product.product_list', [
            'products'=> $products,
        ]);
    }

    function product_delete($product_id){
        $product_image = Product::find($product_id);
        $delete_from  = public_path('uploads/product/preview/'.$product_image->preview);
        unlink($delete_from);

        Product::find($product_id)->delete();

        $thumbnails = Thumbnail::where('product_id', $product_id)->get();
        foreach($thumbnails as $thumbnail){
            $delete_thumbnail_from = public_path('uploads/product/thumbnail/'. $thumbnail->thumbnail);
            unlink($delete_thumbnail_from);
        }
        return back();
    }
}
