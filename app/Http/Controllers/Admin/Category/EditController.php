<?php

namespace App\Http\Controllers\Admin\Category;

use App\Helpers\AdminLeftMenu;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;

class EditController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(Category $category)
    {
        $data = $this->data;
        $data['category'] = $category;
        return view('admin.categories.edit', compact('data'));
    }

}
