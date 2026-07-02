<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function store(UploadedFile $file, string $directory, int $width = 1920, int $height = 1080, ?string $altText = null): Media
    {
        $filename  = uniqid() . '.webp';
        $directory = preg_replace('/\.\.+/', '', ltrim($directory, '/'));
        $directory = preg_replace('/[^a-zA-Z0-9_\-\/]/', '', $directory);
        $directory = trim($directory, '/');
        $path      = "upload/{$directory}/{$filename}";
        $fullPath  = public_path($path);

        if (! is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $this->manager
            ->read($file->getRealPath())
            ->scaleDown(width: $width, height: $height)
            ->toWebp(quality: 85)
            ->save($fullPath);

        [$w, $h] = @getimagesize($fullPath) ?: [null, null];

        return Media::create([
            'filename'  => $filename,
            'path'      => $path,
            'url'       => '/' . $path,
            'mime_type' => 'image/webp',
            'alt_text'  => $altText,
            'size'      => filesize($fullPath) ?: 0,
            'width'     => $w,
            'height'    => $h,
        ]);
    }

    public function delete(Media $media): void
    {
        $fullPath = public_path($media->path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        $media->delete();
    }

    public function deletePath(string $path): void
    {
        $fullPath = public_path(ltrim($path, '/'));
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
