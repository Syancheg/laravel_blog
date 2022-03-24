<?php

namespace App\Http\Controllers\Admin\Post;

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
            $file = File::where(['id' => $oldInput['main_image']])->first();
            if($file) {
                $oldInput['main_image_src'] = $file->path_origin;
                $session->put('_old_input', $oldInput);
            }
        }
        $this->getAllCategories();
        $this->getAllTags();
        $data = $this->data;
        return view('admin.posts.create', compact('data'));
    }
}
