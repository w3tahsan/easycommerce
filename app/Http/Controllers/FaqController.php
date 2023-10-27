<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = Faq::all();
        return view('admin.faq.list', [
            'lists'=> $lists,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faq.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question'=>'required',
            'answer'=>'required',
        ]);

        Faq::insert([
            'question'=>$request->question,
            'answer'=>$request->answer,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success', 'FAQ Added Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $faq = Faq::find($id);
        return view('admin.faq.show', [
            'faq'=> $faq,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $faq = Faq::find($id);
        return view('admin.faq.edit', [
            'faq'=> $faq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'question'=>'required',
            'answer'=>'required',
        ]);

        Faq::find($id)->update([
            'question'=>$request->question,
            'answer'=>$request->answer,
        ]);
        return back()->with('success', 'FAQ Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Faq::find($id)->delete();
        return back()->with('success', 'Faq Deleted Successfully');
    }
}
