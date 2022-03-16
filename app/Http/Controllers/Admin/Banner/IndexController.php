<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class IndexController extends AdminController
{
    private $data;
    private $test;

    public function __construct()
    {
        $this->data = [
            'layout' => [
                'heading_title' => $this->getHeadingTitle(),
                'breadcrumbs' => $this->getBreadcrumbs(),
            ],
            'banners' => Banner::take(ConstantHelper::$TOTAL_FOR_PAGE)->get()
        ];
    }

    public function __invoke()
    {
//        $routes = Route::getRoutes()->getRoutes();
//        dd($routes[26]->action['prefix']);
        $data = $this->data;
        return view('admin.banners.index', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Баннеры';
    }
}
