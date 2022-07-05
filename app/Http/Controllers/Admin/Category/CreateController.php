<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Models\File;
use Illuminate\Support\Facades\Request;

class CreateController extends AdminController
{

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $session = Request::getSession();
        if($session->hasOldInput()){
            $oldInput = $session->getOldInput();
            $image = File::where(['id' => $oldInput['image']])->first();
            if($image) {
                $oldInput['image_src'] = $image->path_origin;
            }
            $banner = File::where(['id' => $oldInput['banner']])->first();
            if($banner) {
                $oldInput['banner_src'] = $banner->path_origin;
            }
            $session->put('_old_input', $oldInput);
        }
        $this->getAllTags();
        $data = $this->data;
        return view('admin.categories.create', compact('data'));
    }

}
