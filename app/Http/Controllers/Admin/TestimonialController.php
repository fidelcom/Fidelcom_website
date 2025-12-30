<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Testimonial::all();
        return view('admin.testimonial.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);
        $img = $request->file('image');
        $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $manager->read($img)->resize(600, 600)->toPng()->save('upload/testimonial/'.$img_name);
        $filename = 'upload/testimonial/'.$img_name;

        Testimonial::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'rating' => 5,
            'location' => $request->location,
            'approved' => 1,
            'image' => $filename,
        ]);

        return redirect()->route('testimonial.index')->with([
            'message' => 'Testimonial created successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Testimonial::findOrFail($id);

        $data->update([
            'approved' => $data->approved == 0 ? 1 : 0
        ]);
        return redirect()->route('testimonial.index')->with([
            'message' => 'Testimonial updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Testimonial::findOrfail($id);
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);
        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->resize(600, 600)->toPng()->save('upload/testimonial/'.$img_name);
            $filename = 'upload/testimonial/'.$img_name;

            if ($data->image)
            {
                unlink($data->image);
            }

            $data->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'rating' => 5,
                'location' => $request->location,
                'approved' => 1,
                'image' => $filename,
            ]);

            return redirect()->route('testimonial.index')->with([
                'message' => 'Testimonial updated successfully!',
                'alert-type' => 'success'
            ]);
        }

        $data->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'rating' => 5,
            'location' => $request->location,
            'approved' => 1,
        ]);

        return redirect()->route('testimonial.index')->with([
            'message' => 'Testimonial updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Testimonial::findOrFail($id);
        if ($data->image)
        {
            unlink($data->image);
        }
        $data->delete();
        return redirect()->route('testimonial.index')->with([
            'message' => 'Testimonial deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
