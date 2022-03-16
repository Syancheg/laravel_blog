<?php

namespace App\Http\Controllers\Admin\Post;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Models\Post;
use App\Helpers\SeoHelper;
use App\Helpers\ConstantHelper;
use App\Models\PostTag;

class StoreController extends AdminController
{
    private $post;
    private $validatedData;
    private $bodyParse;
    private $tags;

    public function __invoke(StoreRequest $request)
    {
        $this->validatedData = $request->validated();
        $this->savePost();
        return redirect()->route('admin.post.index');
    }

    private function savePost(){
        if (isset($this->validatedData['main_image'])) {
            $this->saveImage();
        }
        if (isset($this->validatedData['tags'])) {
            $this->tags = $this->validatedData['tags'];
            unset($this->validatedData['tags']);
        }
        $this->bodyParse = SeoHelper::parseSeoFromBody($this->validatedData);
        $this->post = Post::create($this->bodyParse['body']);
        $this->saveTags();
        $this->saveSeo();
    }

    private function saveImage() {
        $imageHelper = new ImageHelper();
        $this->validatedData['main_image'] = $imageHelper->saveImage($this->validatedData['main_image']);
    }

    private function saveTags() {
        $this->tags = explode('.', $this->tags);
        foreach ($this->tags as $tag) {
            $saveData = [
                'post_id' => $this->post->id,
                'tag_id' => (int)$tag
            ];
            PostTag::firstOrCreate($saveData);
        }
    }

    private function saveSeo() {
        $this->bodyParse['seo']['type'] = ConstantHelper::$POST_TYPE;
        $this->bodyParse['seo']['item_id'] = $this->post->id;
        SeoHelper::saveSeo($this->bodyParse['seo']);
    }
}
