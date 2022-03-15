<?php

namespace App\Http\Controllers\Admin\Post;

use App\Helpers\ConstantHelper;
use App\Helpers\ImageHelper;
use App\Helpers\SeoHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Models\Post;

class UpdateController extends AdminController
{
    public function __invoke(UpdateRequest $request, Post $post)
    {
        $headingTitle = $this->getHeadingTitle();
        $breadcrumbs = $this->getBreadcrumbs();
        $data = $request->validated();
        if (isset($data['main_image'])) {
            $imageHelper = new ImageHelper();
            $oldImage = $post->getAttribute('main_image');
            if (!is_null($oldImage)) {
                $imageHelper->removeImage($oldImage);
            }
            $mainImage = $data['main_image'];
            $data['main_image'] = $imageHelper->saveImage($mainImage);
        }
        $res = SeoHelper::parseSeoFromBody($data);
        $post->update($res['body']);
        $seo = $res['seo'];
        $seo['type'] = ConstantHelper::$POST_TYPE;
        $seo['item_id'] = $post->getAttribute('id');
        SeoHelper::saveSeo($seo);
        return view('admin.posts.show', compact(
            'post',
            'breadcrumbs',
            'headingTitle'
        ));
    }

    private function getHeadingTitle() {
        return 'Просмотр поста';
    }
}
