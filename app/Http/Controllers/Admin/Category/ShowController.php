<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;

class ShowController extends AdminController
{
    public function __invoke(Category $category)
    {
        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        $data['category'] = $category;
        return view('admin.categories.show', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Создание новой категории';
    }
}
