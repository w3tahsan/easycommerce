<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;
use Str;

use function PHPUnit\Framework\returnSelf;

class CategoryController extends Controller
{
    function category(){
        $categories = Category::all();
        return view('admin.category.add_category',[
            'categories'=> $categories,
        ]);
    }

    function category_store(CategoryRequest $request){
        $random_name = Str::lower($request->category_name).'-'.random_int(10000, 99999);
        $category_image = $request->category_image;
        $extension = $category_image->extension();
        $file_name = $random_name.'.'.$extension;

        Image::make($category_image)->save(public_path('uploads/category/'.$file_name));
        Category::insert([
            'category_name'=>$request->category_name,
            'category_image'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('success', 'Category Added!');
    }

    function category_soft_delete($category_id){
        Category::find($category_id)->delete();
        return back();
    }

    function trash_category(){
        $categories = Category::onlyTrashed()->get();
        return view('admin.category.trash', [
            'categories'=> $categories,
        ]);
    }

    function category_restore($category_id){
        Category::onlyTrashed()->find($category_id)->restore();
        return back();
    }
    function permanent_delete($category_id){
        $category = Category::onlyTrashed()->find($category_id);
        $delete_from = public_path('uploads/category/'. $category->category_image);
        unlink($delete_from);
        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back()->with('success', 'Category Deleted Successfully!');
    }

    function checked_delete(Request $request){
        foreach($request->category_id as $category_id){
            $category = Category::withTrashed()->find($category_id);
            $delete_from = public_path('uploads/category/' . $category->category_image);
            unlink($delete_from);
            Category::withTrashed()->find($category_id)->forceDelete();
        }
        return back();
    }

    function category_edit($category_id){
        $category_info = Category::find($category_id);
        return view('admin.category.edit', [
            'category_info'=> $category_info,
        ]);
    }

    function category_update(Request $request){
        if($request->category_image == ''){
            Category::find($request->category_id)->update([
                'category_name'=>$request->category_name,
            ]);
        }
        else{
            $category = Category::find($request->category_id);
            $delete_from = public_path('uploads/category/' . $category->category_image);
            unlink($delete_from);

            $random_name = Str::lower($request->category_name) . '-' . random_int(10000, 99999);
            $category_image = $request->category_image;
            $extension = $category_image->extension();
            $file_name = $random_name.'.'.$extension;

            Image::make($category_image)->save(public_path('uploads/category/'.$file_name));
            Category::find($request->category_id)->update([
                'category_name' => $request->category_name,
                'category_image' => $file_name,
            ]);

            return back();
        }
    }
}
