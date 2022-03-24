<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Controllers\Admin\AdminController;
use App\Models\MenuForRoutes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MenuController extends AdminController
{
    private $paths;

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $this->getPath();
        $data = $this->data;
        return view('admin.common.left_menu', compact('data'));
    }

    public function getPath() {
        $this->data['paths'] = MenuForRoutes::take(config('constants.total_for_page'))->get();
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
}
