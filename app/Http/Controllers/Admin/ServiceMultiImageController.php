<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceMultiImage;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ServiceMultiImageController extends Controller
{
    public function store(Request $request)
    {
        foreach ($request->file('multiImage') as $img)
        {
//                $image = $request->file('image');
            $image_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $manager = new ImageManager(new Driver());
            $manager->read($img)->resize(533, 299)->toPng()->save('upload/services/icon/'.$image_name);
            $filename = 'upload/services/icon/'.$image_name;

            ServiceMultiImage::create([
                'service_id' => $request->service_id,
                'image' => $filename
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Multi Image added successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(string $id)
    {
        $data = ServiceMultiImage::findOrFail($id);

        if ($data->image && file_exists($data->image)) {
            unlink(public_path($data->image));
        }
        $data->delete();

        return redirect()->back()->with([
            'message' => 'Multi Image created successfully!',
            'alert-type' => 'success'
        ]);
    }
}
