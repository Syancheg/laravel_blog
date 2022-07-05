<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Admin\AdminController;
use App\Models\File;
use App\Models\Gallary;
use App\Models\GallaryFile;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Admin\Gallary\StoreRequest;
use App\Http\Requests\Admin\Gallary\UpdateRequest;

class GallaryController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $this->getImageGallaries();
        $data = $this->data;
        return view('admin.common.gallary.index', compact('data'));
    }

    public function viewGallary() {

    }

    public function createGallary() {
        $session = Request::getSession();
        if($session->hasOldInput()){
            $oldInput = $session->getOldInput();
            $file = File::where(['id' => $oldInput['image']])->first();
            if($file) {
                $oldInput['image_src'] = $file->path_origin;
            }
            if(isset($oldInput['images'])){
                $images = [];
                foreach ($oldInput['images'] as $image) {
                    $imageFile = File::where(['id' => $image])->first();
                    if($image) {
                        $images[] = [
                            'id' => $image,
                            'path' => $imageFile->path_origin
                        ];
                    }
                }
                $oldInput['images'] = $images;
            }
            $session->put('_old_input', $oldInput);
        }
        $data = $this->data;
        return view('admin.common.gallary.create', compact('data'));
    }

    public function editGallary(Gallary $gallary) {
        $this->data['gallary'] = $gallary;
        $data = $this->data;
        return view('admin.common.gallary.edit', compact('data'));
    }

    public function copyGallary(Gallary $gallary) {
        $newGallary = $gallary->replicate();
        $newGallary->created_at = time();
        $newGallary->updated_at =  time();
        $newGallary->name .= " (Копия)";
        $newGallary->save();
        if($gallary->images->count()){
            foreach ($gallary->images as $image) {
                $data = [
                    'image_gallary_id' => $newGallary->id,
                    'file_id' => $image->file_id
                ];
                GallaryFile::firstOrCreate($data);
            }
        }



        $this->data['gallary'] = $newGallary;
        $data = $this->data;
        return view('admin.common.gallary.edit', compact('data'));
    }

    public function updateGallary(UpdateRequest $request, $id) {

        $validated = $request->validated();
        $images = [];
        if(isset($validated['images'])){
            $images = $validated['images'];
            unset($validated['images']);
        }
        Gallary::find($id)->update($validated);

        $oldImages = GallaryFile::where(['image_gallary_id' => $id])->get('file_id')->toArray();
        $oldImages = array_map(function($item) {
            return $item['file_id'];
        }, $oldImages);
        $delImages = array_diff($oldImages, $images);

        foreach ($delImages as $delImage){
            GallaryFile::where(['image_gallary_id' => $id, 'file_id' => $delImage])->delete();
        }
        foreach ($images as $image) {
            $data = [
                'image_gallary_id' => $id,
                'file_id' => $image,
            ];
            GallaryFile::firstOrCreate($data);
        }
        return redirect()->route('admin.gallary.index');
    }

    public function deleteGallary(Gallary $gallary) {
        $gallary->delete();
        return redirect()->route('admin.gallary.index');
    }

    public function storeGallary(StoreRequest $request) {
        $validated = $request->validated();
        $images = [];
        if(isset($validated['images'])){
            $images = $validated['images'];
            unset($validated['images']);
        }
        $gallary = Gallary::create($validated);
        if($images){
            foreach ($images as $image) {
                $data = [
                    'image_gallary_id' => $gallary->id,
                    'file_id' => $image,
                ];
                GallaryFile::firstOrCreate($data);
            }
        }
        return redirect()->route('admin.gallary.index');
    }

    private function getImageGallaries() {
        $this->data['gallaries'] = Gallary::paginate(config('constants.total_for_page'));
    }


}
