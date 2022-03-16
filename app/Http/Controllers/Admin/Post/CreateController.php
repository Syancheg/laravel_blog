<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\Tag;

class CreateController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
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
