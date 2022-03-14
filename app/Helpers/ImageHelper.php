<?php


namespace App\Helpers;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ConstantHelper;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    public function saveImage(UploadedFile $uploadedImage) {
        $image['name'] = $uploadedImage->getClientOriginalName();
        $public = 'public/posts/';
        $uploadedImage->move(Storage::path($public).'origin/', $image['name']);
        $this->makeCacheImage($public, $image['name']);
        $image['path_origin'] = $public. 'origin/' . $image['name'];
        $image['path_cache'] = $public . 'cache/' . $this->renameCacheImage($image['name']);
        $file = File::create($image);
        return $file->id;
    }

    private function renameCacheImage($filename) {
        $name = explode('.', $filename);
        $name[0] .= '-' . ConstantHelper::$POST_MAIN_IMAGE_WIDTH . 'x' . ConstantHelper::$POST_MAIN_IMAGE_HEIGTH;
        return implode('.', $name);
    }

    private function makeCacheImage($publicUrl, $name) {
        $imageCache = Image::make(Storage::path($publicUrl).'origin/' . $name);
        $imageCache->fit(ConstantHelper::$POST_MAIN_IMAGE_WIDTH, ConstantHelper::$POST_MAIN_IMAGE_HEIGTH);
        $imageCacheName = Storage::path($publicUrl) . 'cache/' . $this->renameCacheImage($name);
        $imageCache->save($imageCacheName, 80);
    }

    public function removeImage($id) {
        $file = File::where(['id' => $id])->first();
        if(!is_null($file)) {
            Storage::delete([
                $file->path_origin,
                $file->path_cache
            ]);
            $file->delete();
        }
    }
}
