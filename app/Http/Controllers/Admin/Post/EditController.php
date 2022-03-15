<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\Post;
use App\Models\SeoDescription;
use App\Models\Tag;

class EditController extends AdminController
{
    private $data;

    public function __construct()
    {
        $this->data = [
            'layout' => [
                'heading_title' => $this->getHeadingTitle(),
                'breadcrumbs' => $this->getBreadcrumbs(),
            ],
            'categories' => Category::all(),
            'tags' => Tag::all()
        ];
    }

    public function __invoke(Post $post)
    {
        $this->data['post'] = $post;
        $this->getSeo($post->id);
        $this->convertTagsIdToString();
        $data = $this->data;
        return view('admin.posts.edit', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Редатирование поста';
    }

    private function getSeo($postId) {
        $this->data['seo'] = SeoDescription::where(['type' => 1, 'item_id' => $postId])->first();
    }

    private function getTags() {

    }

    private function convertTagsIdToString() {
        $StringTags = '';
        foreach ($this->data['post']->tags as $index => $tag) {
            $StringTags .= $tag->id;
            if ($index < ($this->data['post']->tags->count() - 1)) {
                $StringTags .= '.';
            }
        }
        $this->data['post']->tags = $StringTags;
    }

    private function deleteCurrentTags() {

    }
}
