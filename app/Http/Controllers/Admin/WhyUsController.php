<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\WhyUs;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class WhyUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = WhyUs::all();
        return view('admin.why_us.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.why_us.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'desc' => 'required',
        ]);

        $img = $request->file('image');
        $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $manager->read($img)->scale(846, 420)->toPng()->save('upload/why/'.$img_name);
        $filename = 'upload/why/'.$img_name;

        WhyUs::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'desc' => $request->desc,
            'image' => $filename,
        ]);

        return redirect()->route('why-us.index')->with([
            'message' => 'Why choose us created successfully!',
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
        $data = WhyUs::findOrFail($id);
        return view('admin.why_us.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = WhyUs::findOrfail($id);
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'desc' => 'required',
        ]);

        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->scale(846, 420)->toPng()->save('upload/why/'.$img_name);
            $filename = 'upload/why/'.$img_name;
            if ($data->image && file_exists($data->image)) {
                unlink(public_path($data->image));
            }
            $data->update([
                'image' => $filename
            ]);
        }

        $data->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'desc' => $request->desc,
        ]);

        return redirect()->route('why-us.index')->with([
            'message' => 'Why choose us updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = WhyUs::findOrFail($id);
        $data->delete();
        return redirect()->route('why-us.index')->with([
            'message' => 'Why choose us deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
