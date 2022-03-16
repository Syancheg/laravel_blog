<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Banner;

class IndexController extends AdminController
{

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $data = $this->data;
        return view('admin.banners.index', compact('data'));
    }
}
