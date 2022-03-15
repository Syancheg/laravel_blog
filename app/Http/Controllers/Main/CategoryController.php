<?php

namespace App\Http\Controllers\Main;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\Common\MainMenuController;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __invoke()
    {
        $data['layout']['main_menu'] = MainMenuController::getMenu();
        $data['layout']['styles'] = ConstantHelper::$CATEGORY_STYLES;
        $data['layout']['scripts'] = ConstantHelper::$CATEGORY_SCRIPTS;
        return view('main.category', compact('data'));
    }
}
