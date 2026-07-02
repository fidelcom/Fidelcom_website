<?php

namespace App\Http\Controllers;

use App\Models\Process;
use Illuminate\Http\Request;

class ProcessessController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $data = Process::all();
        return view('frontend.process.index', compact('data'));
    }
}
