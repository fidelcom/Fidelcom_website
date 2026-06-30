<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $data = Gallery::all();
        return view('admin.gallery.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'image.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);

        foreach ($request->file('image') as $img)
        {
//            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->resize(1920, 1280)->toPng()->save('upload/gallery/'.$img_name);
            $filename = 'upload/gallery/'.$img_name;

            Gallery::create([
                'name' => $request->name,
                'image' => $filename,
            ]);
        }

        return redirect()->route('gallery.index')->with([
            'message' => 'Gallery created successfully!',
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
        $data = Gallery::findOrFail($id);
        return view('admin.gallery.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Gallery::findOrfail($id);
        $request->validate([
            'name' => 'required',
        ]);

        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->resize(1920, 1280)->toPng()->save('upload/gallery/'.$img_name);
            $filename = 'upload/gallery/'.$img_name;
            if ($data->image && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }
            $data->update([
                'image' => $filename
            ]);
        }

        $data->update([
            'name' => $request->name,
        ]);

        return redirect()->route('gallery.index')->with([
            'message' => 'Gallery updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Gallery::findOrFail($id);
        if ($data->image && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }
        $data->delete();
        return redirect()->route('gallery.index')->with([
            'message' => 'Gallery us deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
