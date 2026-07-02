<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BlogCategory::all();
        return view('admin.blog_category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        BlogCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('blog-category.index')->with([
            'message' => 'Blog Category created successfully!',
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
        $data = BlogCategory::findOrFail($id);
        return view('admin.blog_category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = BlogCategory::findOrfail($id);
        $request->validate([
            'name' => 'required',
        ]);

        $data->update([
            'name' => $request->name,
        ]);

        return redirect()->route('blog-category.index')->with([
            'message' => 'Blog Category updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = BlogCategory::findOrFail($id);
        $data->delete();
        return redirect()->route('blog-category.index')->with([
            'message' => 'Blog Category us deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
