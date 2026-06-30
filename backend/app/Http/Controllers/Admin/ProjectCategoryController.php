<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use App\Models\Success;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProjectCategory::all();
        return view('admin.project_category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.project_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        ProjectCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('project-category.index')->with([
            'message' => 'Project Category created successfully!',
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
        $data = ProjectCategory::findOrFail($id);
        return view('admin.project_category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = ProjectCategory::findOrfail($id);
        $request->validate([
            'name' => 'required',
        ]);

        $data->update([
            'name' => $request->name,
        ]);

        return redirect()->route('project-category.index')->with([
            'message' => 'Project Category updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProjectCategory::findOrFail($id);
        $data->delete();
        return redirect()->route('project-category.index')->with([
            'message' => 'Project Category us deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
