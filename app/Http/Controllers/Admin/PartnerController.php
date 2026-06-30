<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Partner::all();
        return view('admin.partner.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.partner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp,svg|max:5120',
        ]);
        $img = $request->file('image');
        $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $manager->read($img)->scale(150, 60)->toPng()->save('upload/partners/'.$img_name);
        $filename = 'upload/partners/'.$img_name;

        Partner::create([
            'name' => $request->name,
            'url' => $request->url,
            'image' => $filename,
        ]);

        return redirect()->route('partners.index')->with([
            'message' => 'Partner created successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Partner::findOrFail($id);
        return view('admin.partner.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Partner::findOrfail($id);
        $request->validate([
            'name' => 'required',
        ]);
        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->scale(150, 60)->toPng()->save('upload/partners/'.$img_name);
            $filename = 'upload/partners/'.$img_name;

            if ($data->image && file_exists($data->image)) {
                unlink(public_path($data->image));
            }

            $data->update([
                'name' => $request->name,
                'url' => $request->url,
                'image' => $filename,
            ]);

            return redirect()->route('partners.index')->with([
                'message' => 'Partner updated successfully!',
                'alert-type' => 'success'
            ]);
        }

        $data->update([
            'name' => $request->name,
            'url' => $request->url,
        ]);

        return redirect()->route('partners.index')->with([
            'message' => 'Partner updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Partner::findOrFail($id);
        if ($data->image && file_exists($data->image)) {
            unlink(public_path($data->image));
        }

        $data->delete();
        return redirect()->route('partners.index')->with([
            'message' => 'Partner deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
