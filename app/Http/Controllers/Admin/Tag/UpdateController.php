<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Tag\UpdateRequest;
use App\Models\Tag;

class UpdateController extends AdminController
{
    public function __invoke(UpdateRequest $request, Tag $tag)
    {
        $data = $request->validated();
        $tag->update($data);

        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        $data['tag'] = $tag;
        return view('admin.tags.show', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Просмотр тега';
    }
}
