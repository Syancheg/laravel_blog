<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AdminLeftMenu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Helpers\BreadcrumbsHelper;

class AdminController extends Controller
{
    public $currentRoute;
    public $leftMenu;
    public $data;

    public function getBreadcrumbs()
    {
        $this->currentRoute = Route::currentRouteName();
        $breadcrumbsHelper = new BreadcrumbsHelper();
        return $breadcrumbsHelper->getAdminBreadcrumbs($this->currentRoute);
    }

    public function setupData() {
        $this->data = [
            'layout' => [
                'heading_title' => '',
                'breadcrumbs' => $this->getBreadcrumbs(),
                'sidebar' => [
                    'left_menu' => AdminLeftMenu::getInstance()->adminLeftMenu
                ]
            ]
        ];
    }
}
