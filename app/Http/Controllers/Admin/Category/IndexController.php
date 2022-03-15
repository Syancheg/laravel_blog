<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;

class IndexController extends AdminController
{
    public function __invoke()
    {
        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        $data['categories'] = Category::all();
        return view('admin.categories.index', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Создание новой категории';
    }
}
