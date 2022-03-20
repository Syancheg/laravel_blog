<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Tag\StoreRequest;

class IndexController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
        $this->data['ajax']['rename_tag'] = route('admin.tag.rename-tag');
        $this->data['ajax']['delete_tag'] = route('admin.tag.delete-tag');
        $this->data['ajax']['new_tag'] = route('admin.tag.new-tag');
    }

    public function __invoke()
    {
        $this->getAllTags(true);
        $data = $this->data;
        return view('admin.tags.index', compact('data'));
    }

    public function newTag(StoreRequest $request) {
        $validated = $request->validated();
        $tag = Tag::firstOrCreate($validated);
        return $tag;
    }

    public function renameTag(StoreRequest $request, $id) {
        $validated = $request->validated();
        $tag = Tag::find($id);
        $tag->title = htmlspecialchars($validated['title']);
        if ($tag->save()) {
            return $tag;
        } else {
            return false;
        }

    }

    public function deleteTag($id) {
        $tag = Tag::find($id);
        if($tag->delete()){
            return $tag;
        }
        return false;
    }

}
