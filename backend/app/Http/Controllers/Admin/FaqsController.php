<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\WhyUs;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Faq::all();
        return view('admin.faqs.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('faqs.index')->with([
            'message' => 'FAQS created successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Faq::findOrFail($id);
        return view('admin.faqs.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Faq::findOrfail($id);
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $data->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('faqs.index')->with([
            'message' => 'FAQS updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Faq::findOrFail($id);
        $data->delete();
        return redirect()->route('faqs.index')->with([
            'message' => 'FAQS us deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
