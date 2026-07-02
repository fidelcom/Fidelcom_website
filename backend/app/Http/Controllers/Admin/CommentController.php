<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);
        if ($request->hasFile('image'))
        {
            $img = $request->file('image');
            $image_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->resize(400, 400)->toPng()->save('upload/comment/'.$image_name);
            $filename = 'upload/comment/'.$image_name;
        }
        Comment::create([
            'post_id' => $request->post_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
//            'image' => $filename
        ]);

        return redirect()->back()->with([
            'message' => 'Comment added successfully!',
            'alert-type' => 'success'
        ]);
    }
}
