<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;

class ShowController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(Category $category)
    {
        $data = $this->data;
        $data['category'] = $category;
        return view('admin.categories.show', compact('data'));
    }
}
