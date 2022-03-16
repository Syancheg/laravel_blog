<?php

namespace App\Http\Controllers\Admin\Common;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\MenuForRoutes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MenuController extends AdminController
{
    private $data;
    private $paths;

    public function __construct()
    {
        $this->data = [
            'layout' => [
                'heading_title' => $this->getHeadingTitle(),
                'breadcrumbs' => $this->getBreadcrumbs(),
            ],
            'paths' => MenuForRoutes::take(ConstantHelper::$TOTAL_FOR_PAGE)->get()
        ];
    }

    public function __invoke()
    {
        $data = $this->data;
        return view('admin.common.left_menu', compact('data'));
    }

    public function refreshPath() {
        $rotes = Route::getRoutes()->getRoutes();
        $prefixes = [];
        foreach ($rotes as $route) {
            $prefix = $route->action['prefix'];
            if(preg_match('/admin.\w/', $prefix)) {
                $arrRoute = explode('/', $prefix);
                for ($i = 1; $i < count($arrRoute); $i++) {
                    if (isset($arrRoute[$i])){
                        if (!in_array($arrRoute[$i], $prefixes)) {
                            $prefixes[] = $arrRoute[$i];
                        }
                    }
                }
            }
        }
        $this->paths = $prefixes;
        $this->savePath();
        return 'success';
    }

    private function savePath() {
        foreach ($this->paths as $path) {
            $prefix = MenuForRoutes::where(['path_prefix' => $path])->get();
            if(!$prefix->count()) {
                $data = [
                    'title' => ucfirst($path),
                    'path_prefix' => $path
                ];
                MenuForRoutes::create($data);
            }
        }
    }

    public function editPath(Request $request) {
        echo 1;
    }

    private function getHeadingTitle() {
        return 'Редатирование наименований меню';
    }
}
