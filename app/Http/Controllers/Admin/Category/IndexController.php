<?php

namespace App\Http\Controllers\Admin\Category;

use App\Helpers\AdminLeftMenu;
use App\Helpers\ConstantHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;

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
        $this->data['categories'] = Category::take(ConstantHelper::$TOTAL_FOR_PAGE)->get();
    }
}
