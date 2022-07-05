<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Admin\AdminController;

class IndexController extends AdminController
{

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $data = $this->data;
        return view('admin.main.index', compact('data'));
    }
}
