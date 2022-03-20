<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Admin\AdminController;
use App\Models\CategoryTag;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class IndexController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
        $this->data['ajax']['rename_tag'] = route('admin.tag.rename-tag');
        $this->data['ajax']['delete_tag'] = route('admin.tag.delete-tag');
    }

    public function __invoke()
    {
        $this->getAllTags();
        $data = $this->data;
        return view('admin.tags.index', compact('data'));
    }

    public function renameTag(Request $request, $id) {
        $tag = Tag::find($id);
        $tag->title = htmlspecialchars($request['name']);
        if ($tag->save()) {
            return $tag;
        } else {
            return false;
        }

    }

    public function deleteTag($id) {
        $tag = Tag::find($id);
//        $this->deletePostTag($id);
//        $this->deleteCategoryTag($id);
        if($tag->delete()){
            return $tag;
        }
        return false;
    }

    private function deletePostTag($id) {
        $postTags = PostTag::where(['tag_id' => $id])->get();
        if($postTags->count()) {
            foreach ($postTags as $postTag){
                $postTag->delete();
            }
        }
    }

    private function deleteCategoryTag($id) {
        $categoryTags = CategoryTag::where(['tag_id' => $id])->get();
        if($categoryTags->count() > 0) {
            foreach ($categoryTags as $categoryTag) {
                $categoryTag->delete();
            }
        }
    }

}
