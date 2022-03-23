<?php

namespace App\Http\Controllers\Admin\Post;

use App\Helpers\ConstantHelper;
use App\Helpers\ImageHelper;
use App\Helpers\SeoHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Models\Post;
use App\Models\PostTag;

class UpdateController extends AdminController
{

    private $post;
    private $validatedData;
    private $bodyParse;
    private $deletePostTags = [];

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(UpdateRequest $request, Post $post)
    {
        $this->validatedData = $request->validated();
        $this->validatedData['active'] = isset($this->validatedData['active']);
        $this->post = $post;
        $this->savePost();
        $data = $this->data;
        $data['post'] = $this->post;
        return view('admin.posts.show', compact('data'));
    }

    private function savePost() {

//        dd($this->validatedData['tags']);
        if(isset($this->validatedData['tags'])){
            $this->saveTags();
        }
        $this->bodyParse = SeoHelper::parseSeoFromBody($this->validatedData);
        $this->post->update($this->bodyParse['body']);
        $this->saveSeo();
    }

    private function saveSeo() {
        $this->bodyParse['seo']['type'] = config('constants.seo_post_type');
        $this->bodyParse['seo']['item_id'] = $this->post->id;
        SeoHelper::saveSeo($this->bodyParse['seo']);
    }

    private function saveTags() {
        if(is_null($this->validatedData['tags'])){
            return;
        }
        $oldTegsIds = PostTag::where(['post_id' => $this->post->id])->get('tag_id')->toArray();
        $tags = explode('.', $this->validatedData['tags']);
        if($oldTegsIds){
            $oldTegsIds = array_map(function ($item){
                return (string)$item['tag_id'];
            },$oldTegsIds);
            $this->deletePostTags = array_diff($oldTegsIds, $tags);
            $this->deletePostTags();
        }

        foreach ($tags as $tag) {
            $data = [
                'post_id' => $this->post->id,
                'tag_id' => (int)$tag
            ];
            PostTag::firstOrCreate($data);
        }
        unset($this->validatedData['tags']);
    }

    private function deletePostTags() {
        foreach ($this->deletePostTags as $PostTag) {
            PostTag::where(['post_id' => $this->post->id, 'tag_id' => $PostTag])->delete();
        }
    }
}
