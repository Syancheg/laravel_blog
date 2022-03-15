<?php

namespace App\Http\Controllers\Admin\Post;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;

class IndexController extends AdminController
{
    public function __invoke()
    {
        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        $data['posts'] = Post::take(ConstantHelper::$TOTAL_FOR_PAGE)->get();
        return view('admin.posts.index', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Список постов';
    }
}
