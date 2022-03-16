<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;

class CreateController extends AdminController
{

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $data = $this->data;
        return view('admin.categories.create', compact('data'));
    }

}
