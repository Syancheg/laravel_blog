<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Models\Post;
use App\Helpers\SeoHelper;
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
        if (is_null($this->validatedData['tags'])) {
            unset($this->validatedData['tags']);
        } else if (isset($this->validatedData['tags'])) {
            $this->tags = $this->validatedData['tags'];
            unset($this->validatedData['tags']);
        }
        $this->bodyParse = SeoHelper::parseSeoFromBody($this->validatedData);
        $this->post = Post::create($this->bodyParse['body']);
        $this->saveTags();
        $this->saveSeo();
    }


    private function saveTags() {
        if(is_null($this->tags)){
            return;
        }
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
        $this->bodyParse['seo']['type'] = config('constants.seo_post_type');
        $this->bodyParse['seo']['item_id'] = $this->post->id;
        SeoHelper::saveSeo($this->bodyParse['seo']);
    }
}
