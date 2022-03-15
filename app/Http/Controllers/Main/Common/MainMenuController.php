<?php

namespace App\Http\Controllers\Main\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

const MAIN_MENU_TITLE = [
    'main' => 'Главная',
    'categories' => 'Категории',
    'contact' => 'Контакты',
];

class MainMenuController extends Controller
{
    static function getMenu() {
        $routes = [];
        $allRoutes = Route::getRoutes()->getRoutesByName();
        $currentRoute = Route::currentRouteName();
        foreach ($allRoutes as $index => $route) {
            $names = explode('.', $index);
            if($names[0] === 'top-menu') {
                $routes[] = [
                    'title' => MainMenuController::getTitle($names[1]),
                    'routeName' => $index,
                    'active' => $index === $currentRoute
                ];
            }
        }
        return $routes;
    }

    private static function getTitle($key) {
        if (key_exists($key, MAIN_MENU_TITLE)) {
            return MAIN_MENU_TITLE[$key];
        } else {
            return ucfirst($key);
        }
    }
}
