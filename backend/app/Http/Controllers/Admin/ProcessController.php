<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Process;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Process::all();
        return view('admin.process.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.process.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);
        $img = $request->file('image');
        $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $manager->read($img)->resize(1920, 1280)->toPng()->save('upload/process/'.$img_name);
        $filename = 'upload/process/'.$img_name;

        Process::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'image' => $filename,
        ]);

        return redirect()->route('process.index')->with([
            'message' => 'Process created successfully!',
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
        $data = Process::findOrFail($id);
        return view('admin.process.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Process::findOrfail($id);
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
        ]);
        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->resize(1920, 700)->toPng()->save('upload/process/'.$img_name);
            $filename = 'upload/process/'.$img_name;

            if ($data->image && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $data->update([
                'title' => $request->title,
                'desc' => $request->desc,
                'image' => $filename,
            ]);

            return redirect()->route('process.index')->with([
                'message' => 'Process updated successfully!',
                'alert-type' => 'success'
            ]);
        }

        $data->update([
            'title' => $request->title,
            'desc' => $request->desc,
        ]);

        return redirect()->route('process.index')->with([
            'message' => 'Process updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Process::findOrFail($id);
        if ($data->image && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }
        $data->delete();
        return redirect()->route('process.index')->with([
            'message' => 'Process deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
