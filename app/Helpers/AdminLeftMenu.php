<?php


namespace App\Helpers;
use App\Models\MenuForRoutes;

class AdminLeftMenu
{
    protected static $_instance;
    public $adminLeftMenu;

    public function __construct()
    {
        $this->setupLeftMenu();
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

    private function setupLeftMenu() {
        $menu = $this->getListLeftMenu();
        $this->adminLeftMenu = $this->recursiveSetupData($menu);
    }

    private function recursiveSetupData($menu) {
        for ($i = 0; $i < count($menu); $i++) {
            if(!empty($menu[$i]['children'])) {
                $menu[$i]['title'] = $this->getName($menu[$i]['pathPrefix']);
                $menu[$i]['children'] = $this->recursiveSetupData($menu[$i]['children']);
            } else {
                $menu[$i]['title'] = $this->getName($menu[$i]['pathPrefix']);
            }
        }
        return $menu;
    }

    private function getName($pathPrefix) {
        $titleModel = MenuForRoutes::where(['path_prefix' => $pathPrefix])->get();
        if($titleModel->count()) {
            return $titleModel[0]->title;
        } else {
            $pathPrefix = str_replace('_', ' ', $pathPrefix);
            return ucfirst($pathPrefix);
        }
    }

    private function getListLeftMenu() {
        return [
            [
                'title' => '',
                'status' => false,
                'routeName' => '',
                'pathPrefix' => 'content',
                'icon' => 'fa-list-alt',
                'children' => [
                    [
                        'title' => '',
                        'status' => false,
                        'routeName' => 'admin.post.index',
                        'pathPrefix' => 'post',
                        'icon' => 'fa-circle',
                        'children' => [],
                    ],
                    [
                        'title' => '',
                        'status' => false,
                        'routeName' => 'admin.category.index',
                        'pathPrefix' => 'category',
                        'icon' => 'fa-circle',
                        'children' => [],
                    ],
                    [
                        'title' => '',
                        'status' => false,
                        'routeName' => 'admin.tag.index',
                        'pathPrefix' => 'tag',
                        'icon' => 'fa-circle',
                        'children' => [],
                    ],
                    [
                        'title' => '',
                        'status' => false,
                        'routeName' => 'admin.banner.index',
                        'pathPrefix' => 'banner',
                        'icon' => 'fa-circle',
                        'children' => [],
                    ]

                ]
            ],
            [
                'title' => '',
                'status' => false,
                'routeName' => '',
                'pathPrefix' => 'setting',
                'icon' => 'fa-gears',
                'children' => [
                    [
                        'title' => '',
                        'status' => false,
                        'routeName' => 'admin.setting.left_menu',
                        'pathPrefix' => 'left_menu',
                        'icon' => 'fa-bars',
                        'children' => [],
                    ]
                ]
            ]
        ];
    }

}
