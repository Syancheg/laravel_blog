<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;

class ShowController extends AdminController
{
    public function __invoke(Post $post)
    {
        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        $data['post'] = $post;
        return view('admin.posts.show', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Просмотр поста';
    }
}
