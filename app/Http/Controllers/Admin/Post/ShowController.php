<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;

class ShowController extends AdminController
{
    public function __invoke(Post $post)
    {
        $headingTitle = $this->getHeadingTitle();
        $breadcrumbs = $this->getBreadcrumbs();
        $this->getBreadcrumbs();
        return view('admin.posts.show', compact(
            'post',
            'breadcrumbs',
            'headingTitle'
        ));
    }

    private function getHeadingTitle() {
        return 'Просмотр поста';
    }
}
