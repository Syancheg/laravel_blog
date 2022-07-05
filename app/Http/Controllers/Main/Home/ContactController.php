<?php

namespace App\Http\Controllers\Main\Home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\MainController;
use Illuminate\Http\Request;

class ContactController extends MainController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $data = $this->data;
        return view('main.home.contact', compact('data'));
    }
}
