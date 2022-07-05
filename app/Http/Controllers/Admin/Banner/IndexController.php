<?php

namespace App\Http\Controllers\Admin\Banner;

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
        $this->getBanners();
        $data = $this->data;
        return view('admin.banners.index', compact('data'));
    }

    public function getBanners() {
        $this->data['banners'] = Banner::take(config('constants.total_for_page'))->get();
    }
}
