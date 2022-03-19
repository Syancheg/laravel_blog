<?php

namespace App\Http\Controllers\Main;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\Common\MainMenuController;
use Illuminate\Http\Request;
use const App\Helpers\POST_SCRIPTS;
use const App\Helpers\POST_STYLES;

class PostController extends Controller
{
    public function __invoke()
    {
        $data['layout']['main_menu'] = MainMenuController::getMenu();
        $data['layout']['styles'] = POST_STYLES;
        $data['layout']['scripts'] = POST_SCRIPTS;
        return view('main.post', compact('data'));
    }
}
