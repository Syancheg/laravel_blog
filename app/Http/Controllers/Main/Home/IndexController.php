<?php

namespace App\Http\Controllers\Main\Home;

use App\Http\Controllers\Main\MainController;
use Illuminate\Http\Request;

class IndexController extends MainController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $data = $this->data;
        return view('main.home.index', compact('data'));
    }
}
