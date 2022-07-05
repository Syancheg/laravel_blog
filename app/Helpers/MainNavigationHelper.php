<?php


namespace App\Helpers;


class MainNavigationHelper
{
    protected static $_instance;
    public $navigationList;

    public function __construct()
    {
        $this->navigationList = $this->getNavigationList();
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    private function __clone() {
    }

    public function __wakeup() {
    }

    private function getNavigationList() {
        return [
            [
                'title' => 'Главная',
                'status' => false,
                'routeName' => 'public.home.index',
                'pathPrefix' => '/',
                'icon' => '',
                'children' => []
            ],
            [
                'title' => 'Блог',
                'status' => false,
                'routeName' => 'public.content.blog',
                'pathPrefix' => '/blog',
                'icon' => '',
                'children' => []
            ],
            [
                'title' => 'Питомцы',
                'status' => false,
                'routeName' => 'public.content.dogs',
                'pathPrefix' => '/dogs',
                'icon' => '',
                'children' => []
            ],
            [
                'title' => 'Контакты',
                'status' => false,
                'routeName' => 'public.home.contact',
                'pathPrefix' => '/contact',
                'icon' => '',
                'children' => []
            ]
        ];
    }

}
