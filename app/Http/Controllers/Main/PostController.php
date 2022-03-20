<?php

namespace App\Http\Controllers\Main;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\Common\MainMenuController;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __invoke()
    {
        $data['layout']['main_menu'] = MainMenuController::getMenu();
        $data['layout']['styles'] = ConstantHelper::POST_STYLES;
        $data['layout']['scripts'] = ConstantHelper::POST_SCRIPTS;
        return view('main.post', compact('data'));
    }
}
