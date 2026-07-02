<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Contact::all();
        return view('admin.contact.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'facebook' => 'nullable|string',
            'youtube' => 'nullable|string',
            'google' => 'nullable|string',
            'pinterest' => 'nullable|string',
        ]);

        Contact::create([
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'google' => $request->google,
            'youtube' => $request->youtube,
            'pinterest' => $request->pinterest,
        ]);

        return redirect()->route('contact.index')->with([
            'message' => 'Contact details added successfully!',
            'alert-type' => 'success',
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
        $data = Contact::findOrFail($id);
        return view('admin.contact.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Contact::findOrFail($id);
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'facebook' => 'nullable|string',
            'youtube' => 'nullable|string',
            'google' => 'nullable|string',
            'pinterest' => 'nullable|string',
        ]);

        $data->update([
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'google' => $request->google,
            'youtube' => $request->youtube,
            'pinterest' => $request->pinterest,
        ]);

        return redirect()->route('contact.index')->with([
            'message' => 'Contact details updated successfully!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Contact::findOrFail($id);
        $data->delete();

        return redirect()->route('contact.index')->with([
            'message' => 'Contact details deleted successfully!',
            'alert-type' => 'success',
        ]);
    }
}
