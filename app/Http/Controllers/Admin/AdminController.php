<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Helpers\BreadcrumbsHelper;

class AdminController extends Controller
{
    public $currentRoute;

    public function __construct()
    {
        $this->currentRoute = Route::currentRouteName();
    }

    public function getBreadcrumbs()
    {
        $breadcrumbsHelper = new BreadcrumbsHelper();
        return $breadcrumbsHelper->getAdminBreadcrumbs($this->currentRoute);
    }
}
