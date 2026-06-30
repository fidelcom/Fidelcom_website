<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class HomeFaqsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $data = Faq::all();
        return view('frontend.faqs', compact('data'));
    }
}
