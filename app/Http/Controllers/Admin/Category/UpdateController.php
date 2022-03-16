<?php

namespace App\Http\Controllers\Admin\Category;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Models\Category;

class UpdateController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(UpdateRequest $request, Category $category)
    {
        $validated = $request->validated();
        $category->update($validated);
        $data = $this->data;
        $data['category'] = $category;
        return view('admin.categories.show', compact('data'));
    }

}
