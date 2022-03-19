<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\CategoryTag;

class DeleteController extends AdminController
{
    public function __invoke(Category $category)
    {
        CategoryTag::where(['category_id' => $category->id])->delete();
        $category->delete();
        return redirect()->route('admin.category.index');
    }
}
