<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Models\Category;

class StoreController extends AdminController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        Category::firstOrCreate($data);
        return redirect()->route('admin.category.index');
    }
}
