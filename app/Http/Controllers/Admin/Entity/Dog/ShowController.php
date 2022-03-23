<?php

namespace App\Http\Controllers\Admin\Entity\Dog;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class ShowController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $data = $this->data;
        return view('admin.entities.dogs.show', compact('data'));
    }
}
