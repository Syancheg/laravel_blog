<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\File;
use App\Models\Tag;
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
            $files = File::where(['id' => $oldInput['main_image']])->get();
            if($files->count()) {
                $oldInput['main_image_src'] = $files[0]->path_origin;
                $session->put('_old_input', $oldInput);
            }
        }
        $this->getCategories();
        $this->getTags();
        $data = $this->data;
        return view('admin.posts.create', compact('data'));
    }

    private function getCategories() {
        $this->data['categories'] = Category::all();
    }

    private function getTags() {
        $this->data['tags'] = Tag::all();
    }

}
