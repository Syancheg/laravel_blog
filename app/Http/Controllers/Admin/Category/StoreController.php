<?php

namespace App\Http\Controllers\Admin\Category;

use App\Helpers\SeoHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Models\Category;
use App\Models\PostTag;

class StoreController extends AdminController
{
    private $category;
    private $validatedData;
    private $bodyParse;
    private $tags;

    public function __invoke(StoreRequest $request)
    {

        $this->validatedData = $request->validated();
        $this->saveCategory();
        return redirect()->route('admin.category.index');
    }

    private function saveCategory() {
        if (is_null($this->validatedData['tags'])) {
            unset($this->validatedData['tags']);
        } else if (isset($this->validatedData['tags'])) {
            $this->tags = $this->validatedData['tags'];
            unset($this->validatedData['tags']);
        }
        $this->bodyParse = SeoHelper::parseSeoFromBody($this->validatedData);
        $this->category = Category::firstOrCreate($this->bodyParse['body']);
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
                'post_id' => $this->category->id,
                'tag_id' => (int)$tag
            ];
            PostTag::firstOrCreate($saveData);
        }
    }

    private function saveSeo() {
        $this->bodyParse['seo']['type'] = config('constants.category_type');
        $this->bodyParse['seo']['item_id'] = $this->category->id;
        SeoHelper::saveSeo($this->bodyParse['seo']);
    }
}
