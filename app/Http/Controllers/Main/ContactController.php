<?php

namespace App\Http\Controllers\Main;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\Common\MainMenuController;
use Illuminate\Http\Request;
use const App\Helpers\CONTACT_SCRIPTS;
use const App\Helpers\CONTACT_STYLES;

class ContactController extends Controller
{
    public function __invoke()
    {
        $data['layout']['main_menu'] = MainMenuController::getMenu();
        $data['layout']['styles'] = CONTACT_STYLES;
        $data['layout']['scripts'] = CONTACT_SCRIPTS;
        return view('main.contact', compact('data'));
    }
}
