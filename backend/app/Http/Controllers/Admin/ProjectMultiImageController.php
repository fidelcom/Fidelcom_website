<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectMultiImage;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProjectMultiImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        foreach ($request->file('multiImage') as $img)
        {
//                $image = $request->file('image');
            $image_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->resize(533, 299)->toPng()->save('upload/project/'.$image_name);
            $filename = 'upload/project/'.$image_name;

            ProjectMultiImage::create([
                'project_id' => $request->project_id,
                'image' => $filename
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Multi Image added successfully!',
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProjectMultiImage::findOrFail($id);

        if ($data->image)
        {
            unlink($data->image);
        }
        $data->delete();

        return redirect()->back()->with([
            'message' => 'Multi Image created successfully!',
            'alert-type' => 'success'
        ]);
    }
}
