<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AdminLeftMenu;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallary;
use App\Models\GallaryFile;
use App\Models\Tag;
use App\Models\User;
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

    public function getAllTags($reverse = false) {
        $sort = $reverse ? 'DESC' : 'ASC';
        $this->data['tags'] = Tag::orderBy('id', $sort)->get();
    }

    public function getAllCategories() {
        $this->data['categories'] =  Category::all();
    }

    public function getAllUsers() {
        $this->data['users'] = User::all();
    }

    public function getAllGallaries() {
        $this->data['gallaries'] = Gallary::all();
    }

    public function convertDate($string) {
        $date = explode('-', $string);
        $date = array_reverse($date);
        return implode('.', $date);
    }


}
