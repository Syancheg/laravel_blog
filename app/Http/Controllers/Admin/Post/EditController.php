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
        $headingTitle = $this->getHeadingTitle();
        $breadcrumbs = $this->getBreadcrumbs();
        $seo = SeoDescription::where(['type' => 1, 'item_id' => $post->id])->first();
        $categories = Category::all();
        return view('admin.posts.edit', compact(
            'post',
            'seo',
            'categories',
            'breadcrumbs',
            'headingTitle'
        ));
    }

    private function getHeadingTitle() {
        return 'Редатирование поста';
    }
}
