<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Tag\UpdateRequest;
use App\Models\Tag;

class UpdateController extends AdminController
{

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(UpdateRequest $request, Tag $tag)
    {
        $validated = $request->validated();
        $tag->update($validated);

        $data = $this->data;
        $data['tag'] = $tag;
        return view('admin.tags.show', compact('data'));
    }
}
