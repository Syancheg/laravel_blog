<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Helpers\BreadcrumbsHelper;

class AdminController extends Controller
{
    public $currentRoute;
    public $leftMenu;

    public function getBreadcrumbs()
    {
        $this->currentRoute = Route::currentRouteName();
        $breadcrumbsHelper = new BreadcrumbsHelper();
        return $breadcrumbsHelper->getAdminBreadcrumbs($this->currentRoute);
    }
}
