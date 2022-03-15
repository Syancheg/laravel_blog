<?php


namespace App\Helpers;

const ADMIN_TITLES = [
    'main' => 'Главная',
    'category' => 'Категории',
    'post' => 'Посты',
    'tag' => 'Теги',
    'index' => 'Список',
    'create' => 'Создать',
    'show' => 'Просмотр',
    'edit' => 'Изменить'
];

const ADMIN_MAIN = 'admin.main';

class BreadcrumbsHelper
{

    public function getAdminBreadcrumbs($name) {
        dd($name);
        if ($name === ADMIN_MAIN) {
            $breadcrumbs[0] = [
                'title' => ADMIN_TITLES['main']
            ];
            return $breadcrumbs;
        } else {
            $breadcrumbs[0] = [
                'title' => ADMIN_TITLES['main'],
                'routeName' => 'admin.main'
            ];
        }

        $routeNames = explode('.', $name);
        if($routeNames[2] === 'index') {
            $breadcrumbs[1] = [
                'title' => $this->getTitle($routeNames[1]),
            ];
        } else {
            $breadcrumbs[1] = [
                'title' => $this->getTitle($routeNames[1]),
                'routeName' => $routeNames[0] . '.' . $routeNames[1] . '.' . 'index'
            ];
            $breadcrumbs[2] = [
                'title' => $this->getTitle($routeNames[2]),
            ];
        }
        return $breadcrumbs;
    }

    private function getTitle($key) {
        if (key_exists($key, ADMIN_TITLES)) {
            return ADMIN_TITLES[$key];
        } else {
            return ucfirst($key);
        }
    }
}
