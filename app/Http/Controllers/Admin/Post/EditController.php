<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;
use App\Models\SeoDescription;
use App\Models\Tag;
use Illuminate\Http\Request;

class EditController extends AdminController
{

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(Post $post)
    {
        $this->data['post'] = $post;
        $this->getSeo($post->id);
        $this->convertTagsIdToString();
        $this->getParseTags();
        $this->getAllCategories();
        $data = $this->data;
        return view('admin.posts.edit', compact('data'));
    }

    private function getSeo($postId) {
        $this->data['seo'] = SeoDescription::where(['type' => config('constants.post_type'), 'item_id' => $postId])->first();
    }

    private function getParseTags() {
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

    public function activatePosts(Request $request, $id) {
        $post = Post::find($id);
        $post->active = $request->input('status') === 'true' ? 1 : 0;
        return $post->save();
    }
}
