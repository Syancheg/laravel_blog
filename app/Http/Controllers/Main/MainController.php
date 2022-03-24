<?php

namespace App\Http\Controllers\Main;

use App\Helpers\MainNavigationHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $data;

    public function setupData() {
        $this->data = [
            'layout' => [
                'navigation' => MainNavigationHelper::getInstance()->navigationList
            ]
        ];
    }
}
