<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectMultiImage;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Project::all();
        return view('admin.project.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = ProjectCategory::orderBy('name', 'ASC')->get();
        return view('admin.project.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_category_id' => 'required',
            'title' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);
        $img = $request->file('image');
        $img_name = hexdec(uniqid()).'.webp';
        $manager = new ImageManager(new Driver());
        $manager->read($img)->resize(533, 299)->toWebp()->save('upload/project/'.$img_name);
        $filename = 'upload/project/'.$img_name;

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $i = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        $project = Project::create([
            'project_category_id' => $request->project_category_id,
            'title' => $request->title,
            'slug' => $slug,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'client' => $request->client,
            'year' => $request->year,
            'location' => $request->location,
            'image' => $filename,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        if ($request->hasFile('multiImage'))
        {
            foreach ($request->file('multiImage') as $img)
            {
                $image_name = hexdec(uniqid()).'.webp';
                $manager = new ImageManager(new Driver());
                $manager->read($img)->resize(533, 299)->toWebp()->save('upload/project/'.$image_name);
                $filename = 'upload/project/'.$image_name;

                ProjectMultiImage::create([
                    'project_id' => $project->id,
                    'image' => $filename
                ]);
            }
        }

        return redirect()->route('projects.index')->with([
            'message' => 'Project created successfully!',
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
        $data = Project::findOrFail($id);
        $category = ProjectCategory::orderBy('name', 'ASC')->get();
        return view('admin.project.edit', compact('data', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Project::findOrfail($id);
        $request->validate([
            'project_category_id' => 'required',
            'title' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
        ]);
        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.webp';
            $manager = new ImageManager(new Driver());
            $manager->read($img)->resize(533, 299)->toWebp()->save('upload/project/'.$img_name);
            $filename = 'upload/project/'.$img_name;
            if ($data->image && file_exists($data->image)) {
                unlink(public_path($data->image));
            }

            $data->update([
                'image' => $filename
            ]);
        }

        $data->update([
            'project_category_id' => $request->project_category_id,
            'title' => $request->title,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'client' => $request->client,
            'year' => $request->year,
            'location' => $request->location,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);


        return redirect()->route('projects.index')->with([
            'message' => 'Project updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Project::findOrFail($id);
        if ($data->image && file_exists($data->image)) {
            unlink(public_path($data->image));
        }
        $data->delete();
        return redirect()->route('projects.index')->with([
            'message' => 'Project deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
