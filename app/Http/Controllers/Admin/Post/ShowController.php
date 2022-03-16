<?php

namespace App\Http\Controllers\Admin\Post;

use App\Helpers\AdminLeftMenu;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;

class ShowController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(Post $post)
    {
        $data = $this->data;
        $data['post'] = $post;
        return view('admin.posts.show', compact('data'));
    }
}
