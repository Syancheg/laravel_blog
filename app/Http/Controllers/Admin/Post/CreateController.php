<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;

class CreateController extends AdminController
{
    public function __invoke()
    {
        $headingTitle = $this->getHeadingTitle();
        $breadcrumbs = $this->getBreadcrumbs();
        $categories = Category::all();
        return view('admin.posts.create', compact(
            'categories',
            'breadcrumbs',
            'headingTitle'
        ));
    }

    private function getHeadingTitle() {
        return 'Создание нового поста';
    }

}
