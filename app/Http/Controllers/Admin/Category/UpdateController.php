<?php

namespace App\Http\Controllers\Admin\Category;


use App\Helpers\SeoHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Models\Category;
use App\Models\CategoryTag;

class UpdateController extends AdminController
{
    private $category;
    private $validatedData;
    private $bodyParse;

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(UpdateRequest $request, Category $category)
    {
        $this->validatedData = $request->validated();
        $this->validatedData['active'] = isset($this->validatedData['active']);
        $this->category = $category;
        $this->saveCategory();
        $data = $this->data;
        $data['category'] = $category;
        return view('admin.categories.show', compact('data'));
    }

    private function saveCategory() {
        if(isset($this->validatedData['tags'])){
            $this->saveTags();
        }
        $this->bodyParse = SeoHelper::parseSeoFromBody($this->validatedData);
        $this->category->update($this->bodyParse['body']);
        $this->saveSeo();
    }

    private function saveTags() {
        if(is_null($this->validatedData['tags'])){
            return;
        }
        $tags = explode('.', $this->validatedData['tags']);
        foreach ($tags as $tag) {
            $data = [
                'category_id' => $this->category->id,
                'tag_id' => (int)$tag
            ];
            CategoryTag::firstOrCreate($data);
        }
        unset($this->validatedData['tags']);
    }

    private function saveSeo() {
        $this->bodyParse['seo']['type'] = config('constants.seo_category_type');
        $this->bodyParse['seo']['item_id'] = $this->category->id;
        SeoHelper::saveSeo($this->bodyParse['seo']);
    }

}
