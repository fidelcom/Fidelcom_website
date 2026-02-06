<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminAboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = About::all();
        return view('admin.about.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.about.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'mission' => 'required',
            'vision' => 'required',
            'image' => 'required',
        ]);
        $img = $request->file('image');
        $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $manager->read($img)->resize(380, 250)->toPng()->save('upload/about/'.$img_name);
        $filename = 'upload/about/'.$img_name;

        About::create([
            'title' => $request->title,
            'description' => $request->description,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'image' => $filename,
        ]);

        return redirect()->route('about.index')->with([
            'message' => 'About created successfully!',
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
        $data = About::findOrFail($id);
        return view('admin.about.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, string $id)
//    {
//        $data = About::findOrfail($id);
//        $request->validate([
//            'title' => 'required',
//            'description' => 'required',
//            'mission' => 'required',
//            'vision' => 'required',
//        ]);
////        dd([
////            'hasFile' => $request->hasFile('image'),
////            'isValid' => $request->file('image')->isValid(),
////            'error' => $request->file('image')->getError(),
////            'errorMessage' => $request->file('image')->getErrorMessage(),
////        ]);
//        if ($request->hasFile('image'))
//        {
//            $img = $request->file('image');
//            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
//            $manager = new ImageManager(new Driver());
//            $manager->read($img)->resize(380, 250)->toPng()->save('upload/about/'.$img_name);
//            $filename = 'upload/about/'.$img_name;
////            if ($data->image && file_exists($data->image)) {
////                unlink($data->image);
////            }
//
//            $data->update([
//                'image' => $filename
//            ]);
//        }
//
//        $data->update([
//            'title' => $request->title,
//            'description' => $request->description,
//            'mission' => $request->mission,
//            'vision' => $request->vision,
//        ]);
//
//
//        return redirect()->route('about.index')->with([
//            'message' => 'About updated successfully!',
//            'alert-type' => 'success'
//        ]);
//    }

    public function update(Request $request, string $id)
    {
        $data = About::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'mission' => 'required',
            'vision' => 'required',
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'mission' => $request->mission,
            'vision' => $request->vision,
        ];

        if ($request->hasFile('image')) {

            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();

            $path = public_path('upload/about/'.$img_name);

            $manager = new ImageManager(new Driver());
            $manager->read($img)->resize(558, 591)->toPng()->save($path);

            // delete old image safely
            if ($data->image && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }
            $data->update([
                'image' => 'upload/about/'.$img_name,
            ]);
//            $updateData['image'] = 'upload/about/'.$img_name;
        }

        // update everything once
//        $data->update($updateData);

        return redirect()->route('about.index')->with([
            'message' => 'About updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = About::findOrFail($id);
        if ($data->image)
        {
            unlink($data->image);
        }
        $data->delete();
        return redirect()->route('about.index')->with([
            'message' => 'About deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
