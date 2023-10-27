<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    function sub_category(){
        $categories = Category::all();
        return view('admin.subcategory.subcategory', [
            'categories'=>$categories,
        ]);
    }

    function sub_category_store(Request $request){
        if(Subcategory::where('category_id', $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()){
            return back()->with('exist', 'Subcategory already Exist in this Category!');
        }
        else{
            Subcategory::insert([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
                'created_at' => Carbon::now(),
            ]);

            return back();
        }
    }

    function subcategory_delete($subcategory_id){
        Subcategory::find($subcategory_id)->delete();
        return back();
    }

    function subcategory_edit($subcategory_id){
        $subcategory = Subcategory::find($subcategory_id);
        $categories = Category::all();
        return view('admin.subcategory.edit', [
            'subcategory'=> $subcategory,
            'categories'=> $categories,
        ]);
    }

    function subcategory_update(Request $request){
        Subcategory::find($request->subcategory_id)->update([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
        ]);
        return back();
    }
}
