<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Post::all();
        return view('admin.post.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = BlogCategory::orderBy('name', 'ASC')->get();
        return view('admin.post.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'blog_category_id' => 'required',
            'title' => 'required',
            'author' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);
        $img = $request->file('image');
        $img_name = hexdec(uniqid()).'.webp';
        $manager = new ImageManager(new Driver());
        $manager->read($img)->resize(1920, 1280)->toWebp()->save('upload/post/'.$img_name);
        $filename = 'upload/post/'.$img_name;

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $i = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        Post::create([
            'blog_category_id' => $request->blog_category_id,
            'title' => $request->title,
            'slug' => $slug,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'author' => $request->author,
            'image' => $filename,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('posts.index')->with([
            'message' => 'Post created successfully!',
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
        $data = Post::findOrFail($id);
        $category = BlogCategory::orderBy('name', 'ASC')->get();
        return view('admin.post.edit', compact('data', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Post::findOrfail($id);
        $request->validate([
            'blog_category_id' => 'required',
            'title' => 'required',
            'author' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
        ]);
        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.webp';
            $manager = new ImageManager(new Driver());
            $manager->read($img)->resize(1920, 1280)->toWebp()->save('upload/post/'.$img_name);
            $filename = 'upload/post/'.$img_name;
            if ($data->image && file_exists($data->image)) {
                unlink(public_path($data->image));
            }

            $data->update([
                'image' => $filename
            ]);
        }

        $data->update([
            'blog_category_id' => $request->blog_category_id,
            'title' => $request->title,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'author' => $request->author,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);


        return redirect()->route('posts.index')->with([
            'message' => 'Post updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Post::findOrFail($id);
        if ($data->image && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }
        $data->delete();
        return redirect()->route('posts.index')->with([
            'message' => 'Post deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
