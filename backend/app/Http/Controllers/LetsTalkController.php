<?php

namespace App\Http\Controllers;

use App\Http\Requests\LetsTalkFormRequest;
use App\Models\LetsTalk;
use Illuminate\Http\Request;

class LetsTalkController extends Controller
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
    public function store(LetsTalkFormRequest $request)
    {
        LetsTalk::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'service' => $request->service,
            'status'  => 0,
        ]);

        return response()->json([
            'code'    => true,
            'success' => 'Your message has been sent successfully!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data = LetsTalk::latest()->get();
        return view('admin.lets_talk.index', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = LetsTalk::findOrFail($id);

        $data->update([
            'status' => $data->status == 1 ? 0 : 1
        ]);

        return redirect()->back()->with([
            'message' => 'Status updated successfully!',
            'alert-type' => 'success'
        ]);
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
        $data = LetsTalk::findOrFail($id);
        $data->delete();
        return redirect()->back()->with([
            'message' => 'Message deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
