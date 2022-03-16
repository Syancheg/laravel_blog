<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Tag;

class ShowController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(Tag $tag)
    {
        $data = $this->data;
        $data['tag'] = $tag;
        return view('admin.tags.show', compact('data'));
    }

}
