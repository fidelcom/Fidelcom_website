<?php

namespace App\Http\Controllers;

use App\Models\GetInTouch;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'    => 'required|string|max:255',
                'phone'   => 'required|string|max:20',
                'email'   => 'required|email',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            GetInTouch::create([
                'name'    => $validated['name'],
                'email'   => $validated['email'],
                'phone'   => $validated['phone'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'status'  => 0,
            ]);

            return response()->json([
                'code'    => true,
                'success' => 'Your message has been sent successfully!',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            $errors = $e->validator->errors();

            return response()->json([
                'code'  => false,
                'field' => $errors->keys()[0],
                'err'   => $errors->first(),
            ], 422);
        }
    }

    public function show()
    {
        $data = GetInTouch::latest()->get();
        return view('admin.get_in_touch.index', compact('data'));
    }

    public function edit($id)
    {
        $data = GetInTouch::findOrFail($id);

        $data->update([
            'status' => $data->status == 1 ? 0 : 1
        ]);

        return redirect()->back()->with([
            'message' => 'Status updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $data = GetInTouch::findOrFail($id);
        $data->delete();
        return redirect()->back()->with([
            'message' => 'Message deleted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
