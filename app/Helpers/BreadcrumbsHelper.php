<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Route;

const ADMIN_TITLES = [
    'main' => 'Главная',
    'category' => 'Категории',
    'post' => 'Посты',
    'tag' => 'Теги',
    'banner' => 'Баннеры',
    'index' => 'Список',
    'create' => 'Создать',
    'show' => 'Просмотр',
    'edit' => 'Изменить'
];

const ADMIN_MAIN = 'admin.main';

class BreadcrumbsHelper
{
    private $breadcrumbs;
    private $name;
    private $tmpBreadcrumbs = [];

    public function getAdminBreadcrumbs($name) {
//        $this->breadcrumbs[] = [
//            'title' => 'Главная',
//        ];
//        if(\Request::route()->getName() !== 'admin.main') {
//            $this->breadcrumbs['routeName'] = 'admin.main';
//        }
//        $this->name = $name;
//
//        if ($name === ADMIN_MAIN) {
//            $breadcrumbs[0] = [
//                'title' => ADMIN_TITLES['main']
//            ];
//            return $breadcrumbs;
//        } else {
//            $breadcrumbs[0] = [
//                'title' => ADMIN_TITLES['main'],
//                'routeName' => 'admin.main'
//            ];
//        }
//
//        $routeNames = explode('.', $name);
//        if($routeNames[2] === 'index') {
//            $breadcrumbs[1] = [
//                'title' => $this->getTitle($routeNames[1]),
//            ];
//        } else {
//            $breadcrumbs[1] = [
//                'title' => $this->getTitle($routeNames[1]),
////                'routeName' => $routeNames[0] . '.' . $routeNames[1] . '.' . 'index'
//            ];
//            if($routeNames[1] === 'setting') {
//                $breadcrumbs[1]['routeName'] = $routeNames[0] . '.' . $routeNames[1] . '.' . $routeNames[2];
//            } else {
//                $breadcrumbs[1]['routeName'] = $routeNames[0] . '.' . $routeNames[1] . '.' . 'index';
//            }
//            $breadcrumbs[2] = [
//                'title' => $this->getTitle($routeNames[2]),
//            ];
//        }
        return [];
    }

    private function recursiveBreadcrumbs($menu) {
        for ($i = 0; $i < count($menu); $i++) {
            $this->tmpBreadcrumbs[] = [

            ];
        }
    }

    private function getTitle($key) {
        if (key_exists($key, ADMIN_TITLES)) {
            return ADMIN_TITLES[$key];
        } else {
            return ucfirst($key);
        }
    }
}
