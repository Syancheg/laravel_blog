<?php

namespace App\Http\Controllers\Main;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\Common\MainMenuController;
use Illuminate\Http\Request;
use const App\Helpers\MAIN_SCRIPTS;
use const App\Helpers\MAIN_STYLES;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data['layout']['main_menu'] = MainMenuController::getMenu();
        $data['layout']['styles'] = MAIN_STYLES;
        $data['layout']['scripts'] = MAIN_SCRIPTS;
        return view('main.index', compact('data'));
    }
}
