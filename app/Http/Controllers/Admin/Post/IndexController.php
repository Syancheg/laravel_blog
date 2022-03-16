<?php

namespace App\Http\Controllers\Admin\Post;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;

class IndexController extends AdminController
{

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {
        $this->getPosts();
        $data = $this->data;
        return view('admin.posts.index', compact('data'));
    }

    private function getPosts() {
        $this->data['posts'] = Post::take(ConstantHelper::$TOTAL_FOR_PAGE)->get();
    }
}
