<?php

namespace App\Http\Controllers\Admin\Entity\Dog;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Dog;
use Illuminate\Http\Request;

class IndexController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $this->getDogs();
//        dd($this->data['dogs']);
        $data = $this->data;
        return view('admin.entities.dogs.index', compact('data'));
    }

    private function getDogs() {
        $this->data['dogs'] = Dog::paginate(config('constants.total_for_page'));
    }
}
