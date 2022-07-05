<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Category;
use App\Models\SeoDescription;
use App\Models\Tag;

class EditController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(Category $category)
    {
        $this->data['category'] = $category;
        $this->getSeo($category->id);
        $this->convertTagsIdToString();
        $this->getParseTags();
        $data = $this->data;
        return view('admin.categories.edit', compact('data'));
    }

    private function getSeo($categoryId) {
        $this->data['seo'] = SeoDescription::where(['type' => config('constants.category_type'), 'item_id' => $categoryId])->first();
    }

    private function getParseTags() {
        $arrTagsId = explode('.', $this->data['category']->tags);
        $tags = Tag::all();
        foreach ($tags as $tag) {
            if (!in_array($tag->id, $arrTagsId)) {
                $this->data['new_tags'][] = $tag;
            } else {
                $this->data['cur_tags'][] = $tag;
            }
        }
    }

    private function convertTagsIdToString() {
        $StringTags = '';
        foreach ($this->data['category']->tags as $index => $tag) {
            $StringTags .= $tag->tag_id;
            if ($index < ($this->data['category']->tags->count() - 1)) {
                $StringTags .= '.';
            }
        }
        $this->data['category']->tags = $StringTags;
    }

}
