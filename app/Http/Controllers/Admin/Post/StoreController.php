<?php

namespace App\Http\Controllers\Admin\Post;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Models\Post;
use App\Helpers\SeoHelper;
use App\Helpers\ConstantHelper;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
//        dd($data);
        if (isset($data['main_image'])) {
            $imageHelper = new ImageHelper();
            $mainImage = $data['main_image'];
            $data['main_image'] = $imageHelper->saveImage($mainImage);
        }
        $res = SeoHelper::parseSeoFromBody($data);
        $post = Post::create($res['body']);
        $seo = $res['seo'];
        $seo['type'] = ConstantHelper::$POST_TYPE;
        $seo['item_id'] = $post->id;
        SeoHelper::saveSeo($seo);
        return redirect()->route('admin.post.index');
    }
}
