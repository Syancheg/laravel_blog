<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Tag;

class IndexController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $this->getAllTags();
        $data = $this->data;
        return view('admin.tags.index', compact('data'));
    }

}
