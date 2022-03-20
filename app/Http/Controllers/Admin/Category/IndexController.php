<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\Post;

class IndexController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $this->getCategories();
        $data = $this->data;
        return view('admin.categories.index', compact('data'));
    }

    private function getCategories(){
        $this->data['categories'] = Category::paginate(config('constants.total_for_page'));
    }
}
