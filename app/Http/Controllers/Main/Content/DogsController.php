<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Main\MainController;
use Illuminate\Http\Request;

class DogsController extends MainController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $data = $this->data;
        return view('main.content.dogs', compact('data'));
    }
}
