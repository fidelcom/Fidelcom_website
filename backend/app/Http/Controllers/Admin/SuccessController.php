<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Success;
use Illuminate\Http\Request;

class SuccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Success::all();
        return view('admin.success.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.success.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'value' => 'required',
        ]);

        Success::create([
            'title' => $request->title,
            'value' => $request->value,
        ]);

        return redirect()->route('success-story.index')->with([
            'message' => 'Success story created successfully!',
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
        $data = Success::findOrFail($id);
        return view('admin.success.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Success::findOrfail($id);
        $request->validate([
            'title' => 'required',
            'value' => 'required',
        ]);

        $data->update([
            'title' => $request->title,
            'value' => $request->value,
        ]);

        return redirect()->route('success-story.index')->with([
            'message' => 'Success story updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Success::findOrFail($id);
        $data->delete();
        return redirect()->route('success-story.index')->with([
            'message' => 'Success story us deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
