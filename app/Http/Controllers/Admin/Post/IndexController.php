<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;

class IndexController extends AdminController
{
    public function __invoke()
    {
        $headingTitle = $this->getHeadingTitle();
        $breadcrumbs = $this->getBreadcrumbs();
        $posts = Post::take(20)->get();
        return view('admin.posts.index', compact(
            'posts',
            'breadcrumbs',
            'headingTitle'
        ));
    }

    private function getHeadingTitle() {
        return 'Список постов';
    }
}
