<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Inventory;
use App\Models\ItemLeser;
use App\Models\Product;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Inventorycontroller extends Controller
{
    function variation(){
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product.variation', [
            'colors' => $colors ,
            'sizes' => $sizes ,
        ]);
    }
    function color_store(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
        ]);
        return back();
    }

    function color_delete($color_id){
        Color::find($color_id)->delete();
        return back();
    }

    function size_store(Request $request){
        Size::insert([
            'size_name'=>$request->size_name,
        ]);
        return back();
    }
    function product_inventory($product_id){
        $product_info = Product::find($product_id);
        $colors = Color::all();
        $sizes = Size::all();
        $inventories = Inventory::where('product_id', $product_id)->get();
        return view('admin.product.inventory', [
            'product_info'=>$product_info,
            'colors'=> $colors,
            'sizes'=> $sizes,
            'inventories'=> $inventories,
        ]);
    }
    function inventory_store(Request $request){
        if(Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
            Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return back();

            ItemLeser::insert([
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'quantity_stockin' => $request->quantity,
                'created_at' => Carbon::now(),
            ]);
        }
        else{
            Inventory::insert([
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'quantity' => $request->quantity,
                'created_at' => Carbon::now(),
            ]);

            ItemLeser::insert([
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'quantity_stockin' => $request->quantity,
                'created_at' => Carbon::now(),
            ]);

            return back();
        }

    }
}
