<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;

class CreateController extends AdminController
{
    public function __invoke()
    {
        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        $data['categories'] = Category::all();
        return view('admin.posts.create', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Создание нового поста';
    }

}
