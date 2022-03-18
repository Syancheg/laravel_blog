<?php


namespace App\Helpers;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ConstantHelper;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    private $uploadedImage;
    private $imageOriginalName;
    private $currentPath;
    private $baseOriginPath;
    private $originPath;
    private $cachePath;
    private $baseCachePath;

    public function __construct()
    {
        $this->baseOriginPath = 'public/origin/';
        $this->baseCachePath = 'public/cache/';
    }


    public function saveImage(UploadedFile $uploadedImage, $path = '') {
        $this->uploadedImage = $uploadedImage;
        $this->imageOriginalName = $uploadedImage->getClientOriginalName();
        $this->originPath = $this->baseOriginPath . $path;
        $this->cachePath = $this->baseCachePath . $path;
        $this->uploadedImage->move(Storage::path($this->originPath), $this->imageOriginalName);

//        $this->makeCacheImage();
        $image['path_origin'] = $this->originPath . $this->imageOriginalName;
//        $image['path_cache'] = $this->cachePath . $this->renameCacheImage();
        $image['path_cache'] = '';
        $image['name'] = $this->imageOriginalName;
        $file = File::firstOrCreate($image);
        return $file->id;
    }

    private function renameCacheImage() {
        $name = explode('.', $this->imageOriginalName);
        $name[0] .= '-' . ConstantHelper::$POST_MAIN_IMAGE_WIDTH . 'x' . ConstantHelper::$POST_MAIN_IMAGE_HEIGTH;
        return implode('.', $name);
    }

    private function makeCacheImage() {
        $imageCache = Image::make(Storage::path($this->originPath) . $this->imageOriginalName);
        $imageCache->fit(ConstantHelper::$POST_MAIN_IMAGE_WIDTH, ConstantHelper::$POST_MAIN_IMAGE_HEIGTH);
        $imageCacheName = Storage::path($this->cachePath) . $this->renameCacheImage();
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
