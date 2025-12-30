<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeServicesController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $contact = Contact::first();
        return view('services.index', compact('services', 'contact'));
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        $services = Service::where('id', '!=', $id)->limit(4)->get();
        $contact = Contact::first();
        return view('services.show', compact('service', 'services', 'contact'));
    }
}
