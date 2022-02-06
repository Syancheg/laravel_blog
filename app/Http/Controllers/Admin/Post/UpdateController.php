<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Models\Post;
use App\Models\SeoDescription;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Post $post)
    {

        $data = $request->validated();
        $post->update($data);

        $parameters = $request->request->all();
        $seo = [
            'type' => 1,
            'seo_title' => $parameters['seo_title'],
            'seo_description' => $parameters['seo_description'],
            'seo_keywords' => $parameters['seo_keywords'],
            'item_id' => $post->getAttribute('id'),
        ];
        $this->setSeoDescription($seo);
        return view('admin.posts.show', compact('post'));
    }

    private function setSeoDescription($seo) {


        $seoObject = SeoDescription::where(['type' => 1, 'item_id' => $seo['item_id']])->first();
        if(is_null($seoObject)){
            SeoDescription::create($seo);
        } else {
            $seoObject->update($seo);
        }

    }
}
