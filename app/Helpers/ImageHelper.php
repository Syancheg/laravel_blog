<?php


namespace App\Helpers;
use App\Models\File;
use App\Models\ImagesCache;
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

    public function getImageOrigin($id) {
        if(is_null($id)) {
            return 'public/noimg.png';
        }
        return File::find($id);
    }

    public function getImageCache($id, $resolution) {
        if(is_null($id)) {
            return 'public/noimg.png';
        }
        $resStr = $resolution['width'] . '-' . $resolution['height'];
        $cache = ImagesCache
            ::where(['file_id' => $id, 'resolution' => $resStr])
            ->first();
        if(is_null($cache)) {
            return $this->createCashImage($id, $resolution);
        } else {
            return $cache->path;
        }
    }

    private function createCashImage($id, $resolution) {
        $file = File::find($id);
        $path = $file->path_origin;
        $name = $resolution['width'] . '-' . $resolution['height'];
        $cachePath = str_replace('origin', 'cache/' . $name, $path);
        $cacheImage = Image::make(Storage::path($path))
            ->resize($resolution['width'], $resolution['height'],
            function ($constraint) {
                $constraint->aspectRatio();
            });
        $dir = Storage::path(substr($cachePath, 0, strripos($cachePath, '/')));
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $cacheImage->save(Storage::path($cachePath), 80);
        $data = [
            'file_id' => $id,
            'resolution' => $name,
            'path' => $cachePath,
        ];
        ImagesCache::firstOrCreate($data);
        return $cachePath;
    }


    public function saveImage(UploadedFile $uploadedImage, $path = '') {
        $this->uploadedImage = $uploadedImage;
        $this->imageOriginalName = $uploadedImage->getClientOriginalName();
        $this->originPath = $this->baseOriginPath . $path;
        $this->uploadedImage->move(Storage::path($this->originPath), $this->imageOriginalName);
        $image['path_origin'] = $this->originPath . $this->imageOriginalName;
        $image['path_cache'] = '';
        $image['name'] = $this->imageOriginalName;
        $file = File::firstOrCreate($image);
        return $file->id;
    }

    public function removeImage($id) {
        $file = File::find($id);
        if(!is_null($file)) {
            $this->removeCache($id);
            Storage::delete([
                $file->path_origin
            ]);
            $file->delete();
        }
    }

    private function removeCache($id) {
        $images = ImagesCache::where(['file_id' => $id])->get();
        if($images->count() > 0) {
            foreach ($images as $image) {
                Storage::delete([
                    $image->path
                ]);
                $image->delete();
            }
        }
    }
}
