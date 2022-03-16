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
        ];
    }

    public function __invoke(Post $post)
    {
        $this->data['post'] = $post;
        $this->getSeo($post->id);
        $this->convertTagsIdToString();
        $this->getTags();
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
        $arrTagsId = explode('.', $this->data['post']->tags);
        $tags = Tag::all();
        foreach ($tags as $tag) {
            if (!in_array($tag->id, $arrTagsId)) {
                $this->data['new_tags'][] = $tag;
            } else {
                $this->data['cur_tags'][] = $tag;
            }
        }
    }

    private function convertTagsIdToString() {
        $StringTags = '';
        foreach ($this->data['post']->tags as $index => $tag) {
            $StringTags .= $tag->tag_id;
            if ($index < ($this->data['post']->tags->count() - 1)) {
                $StringTags .= '.';
            }
        }
        $this->data['post']->tags = $StringTags;
    }
}
