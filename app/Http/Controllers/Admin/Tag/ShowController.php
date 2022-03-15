<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Tag;

class ShowController extends AdminController
{
    public function __invoke(Tag $tag)
    {
        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        $data['tag'] = $tag;
        return view('admin.tags.show', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Просмотр тега';
    }
}
