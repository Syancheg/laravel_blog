<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\Post;
use App\Models\SeoDescription;

class EditController extends AdminController
{
    public function __invoke(Post $post)
    {
        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        $data['seo'] = SeoDescription::where(['type' => 1, 'item_id' => $post->id])->first();
        $data['categories'] = Category::all();
        $data['post'] = $post;
        return view('admin.posts.edit', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Редатирование поста';
    }
}
