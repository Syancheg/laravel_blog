<?php

namespace App\Http\Controllers\Admin\Tag;

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
        return view('admin.tags.create', compact('data'));
    }
}
