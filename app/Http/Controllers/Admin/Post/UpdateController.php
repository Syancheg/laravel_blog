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

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(UpdateRequest $request, Post $post)
    {
        $this->validatedData = $request->validated();
        $this->post = $post;
        $this->savePost();
        $data = $this->data;
        $data['post'] = $this->post;
        return view('admin.posts.show', compact('data'));
    }

    private function savePost() {
        if (isset($this->validatedData['main_image'])) {
            $this->saveImage();
        }
        if(isset($this->validatedData['tags'])){
            $this->saveTags();
        }
        $this->bodyParse = SeoHelper::parseSeoFromBody($this->validatedData);
        $this->post->update($this->bodyParse['body']);
        $this->saveSeo();
    }

    private function saveImage() {
        $imageHelper = new ImageHelper();
        $oldImage = $this->post->getAttribute('main_image');
        if (!is_null($oldImage)) {
            $imageHelper->removeImage($oldImage);
        }
        $this->validatedData['main_image'] = $imageHelper->saveImage($this->validatedData['main_image']);
    }

    private function saveSeo() {
        $this->bodyParse['seo']['type'] = ConstantHelper::$POST_TYPE;
        $this->bodyParse['seo']['item_id'] = $this->post->id;
        SeoHelper::saveSeo($this->bodyParse['seo']);
    }

    private function saveTags() {
        $tags = explode('.', $this->validatedData['tags']);
        foreach ($tags as $tag) {
            $data = [
                'post_id' => $this->post->id,
                'tag_id' => (int)$tag
            ];
            PostTag::firstOrCreate($data);
        }
        unset($this->validatedData['tags']);
    }

    private function removeTags() {

    }

    private function checkTags(){

    }
}
