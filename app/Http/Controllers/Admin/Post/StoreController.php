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
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        if (isset($data['main_image'])) {
            $imageHelper = new ImageHelper();
            $mainImage = $data['main_image'];
            $data['main_image'] = $imageHelper->saveImage($mainImage);
        }
        $tags = '';
        if (isset($data['tags'])) {
            $tags = $data['tags'];
            unset($data['tags']);
        }
        $res = SeoHelper::parseSeoFromBody($data);
        $post = Post::create($res['body']);
        if($tags) {
            $this->saveTags($post->id, $tags);
        }
        $seo = $res['seo'];
        $seo['type'] = ConstantHelper::$POST_TYPE;
        $seo['item_id'] = $post->id;
        SeoHelper::saveSeo($seo);
        return redirect()->route('admin.post.index');
    }

    private function saveTags($postId, $tags) {
        $tags = explode('.', $tags);
        foreach ($tags as $tag) {
            $saveData = [
                'post_id' => $postId,
                'tag_id' => (int)$tag
            ];
            PostTag::firstOrCreate($saveData);
        }
    }
}
