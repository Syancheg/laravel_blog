<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;

class DeleteController extends AdminController
{
    public function __invoke(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.category.index');
    }
}
