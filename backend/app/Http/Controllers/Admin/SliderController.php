<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Slider::all();
        return view('admin.slider.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'project' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);
        $img = $request->file('image');
        $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $manager->read($img)->scale(1920, 1280)->toPng()->save('upload/slider/'.$img_name);
        $filename = 'upload/slider/'.$img_name;

        Slider::create([
            'title' => $request->title,
            'description' => $request->description,
            'project' => $request->project,
            'image' => $filename,
        ]);

        return redirect()->route('slider.index')->with([
            'message' => 'Slider created successfully!',
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
        $data = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Slider::findOrfail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'project' => 'required',
        ]);
        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->scale(1920, 700)->toPng()->save('upload/slider/'.$img_name);
            $filename = 'upload/slider/'.$img_name;

            if ($data->image && file_exists($data->image)) {
                unlink(public_path($data->image));
            }

            $data->update([
                'title' => $request->title,
                'description' => $request->description,
                'project' => $request->project,
                'image' => $filename,
            ]);

            return redirect()->route('slider.index')->with([
                'message' => 'Slider updated successfully!',
                'alert-type' => 'success'
            ]);
        }

        $data->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('slider.index')->with([
            'message' => 'Slider updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Slider::findOrFail($id);
        if ($data->image && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }
        $data->delete();
        return redirect()->route('slider.index')->with([
            'message' => 'Slider deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
