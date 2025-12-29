<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceMulitImage;
use App\Models\ServiceMultiImage;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Service::all();
        return view('admin.services.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'image' => 'required',
        ]);
        $img = $request->file('image');
        $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $manager->read($img)->scale(558, 591)->toPng()->save('upload/services/'.$img_name);
        $filename = 'upload/services/'.$img_name;

        $service = Service::create([
            'title' => $request->title,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'image' => $filename,
        ]);

        if ($request->hasFile('icon'))
        {
            foreach ($request->file('icon') as $icon)
            {
//                $icon = $request->file('icon');
                $icon_name = hexdec(uniqid()).'.'.$icon->getClientOriginalExtension();
                $icon_manager = new ImageManager(new Driver());
                $icon_manager->read($icon)->scale(558, 591)->toPng()->save('upload/services/icon/'.$icon_name);
                $icon_name = 'upload/services/icon/'.$icon_name;

                ServiceMultiImage::create([
                    'service_id' => $service->id,
                    'image' => $icon_name
                ]);
            }
        }

        return redirect()->route('services.index')->with([
            'message' => 'Service created successfully!',
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
        $data = Service::findOrFail($id);
        return view('admin.services.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Service::findOrfail($id);
        $request->validate([
            'title' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
        ]);
        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->scale(558, 591)->toPng()->save('upload/services/'.$img_name);
            $filename = 'upload/services/'.$img_name;
            if ($data->image && file_exists($data->image)) {
                unlink(public_path($data->image));
            }

            $data->update([
                'image' => $filename
            ]);
        }

        $data->update([
            'title' => $request->title,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
        ]);


        return redirect()->route('services.index')->with([
            'message' => 'Service updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Service::findOrFail($id);
        if ($data->image && file_exists($data->image)) {
            unlink(public_path($data->image));
        }
        $data->delete();
        return redirect()->route('services.index')->with([
            'message' => 'Service deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
