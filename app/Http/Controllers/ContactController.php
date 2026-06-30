<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use App\Models\GetInTouch;
use App\Models\Service;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contact  = Contact::first();
        $services = Service::select('id', 'title')->orderBy('title')->get();
        return view('contact.index', compact('contact', 'services'));
    }

    public function store(ContactFormRequest $request)
    {
        $message = $request->message;

        if ($request->filled('company')) {
            $message = "Company: {$request->company}\n\n" . $message;
        }

        if ($request->filled('budget')) {
            $message .= "\n\nBudget: {$request->budget}";
        }

        GetInTouch::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'subject' => $request->subject,
            'message' => $message,
            'status'  => 0,
        ]);

        return response()->json([
            'code'    => true,
            'success' => 'Your message has been sent successfully!',
        ]);
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
