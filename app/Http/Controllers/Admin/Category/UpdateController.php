<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Models\Category;

class UpdateController extends AdminController
{
    public function __invoke(UpdateRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);
        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        $data['category'] = $category;
        return view('admin.categories.show', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Создание новой категории';
    }
}
