<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Tag;

class IndexController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $this->getTags();
        $data = $this->data;
        return view('admin.tags.index', compact('data'));
    }

    private function getTags() {
        $this->data['tags'] = Tag::take(ConstantHelper::$TOTAL_FOR_PAGE)->get();
    }

}
