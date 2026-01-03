<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\WhyUs;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Team::all();
        return view('admin.team.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'instagram' => 'required',
            'linkedin' => 'required',
            'twitter' => 'required',
            'image' => 'required',
        ]);

        $img = $request->file('image');
        $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $manager = new ImageManager(new Driver());
        $manager->read($img)->scale(800, 1090)->toPng()->save('upload/team/'.$img_name);
        $filename = 'upload/team/'.$img_name;

        Team::create([
            'name' => $request->name,
            'position' => $request->position,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'twitter' => $request->twitter,
            'image' => $filename,
        ]);

        return redirect()->route('team.index')->with([
            'message' => 'Team created successfully!',
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
        $data = Team::findOrFail($id);
        return view('admin.team.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Team::findOrfail($id);
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'instagram' => 'required',
            'linkedin' => 'required',
            'twitter' => 'required',
            'image' => 'required',
        ]);

        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $img_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->scale(800, 1090)->toPng()->save('upload/team/'.$img_name);
            $filename = 'upload/team/'.$img_name;
            if ($data->image && file_exists($data->image)) {
                unlink(public_path($data->image));
            }
            $data->update([
                'image' => $filename
            ]);
        }

        $data->update([
            'name' => $request->name,
            'position' => $request->position,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'twitter' => $request->twitter,
        ]);

        return redirect()->route('team.index')->with([
            'message' => 'Team updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Team::findOrFail($id);
        if ($data->image && file_exists($data->image)) {
            unlink(public_path($data->image));
        }
        $data->delete();
        return redirect()->route('team.index')->with([
            'message' => 'Team us deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
