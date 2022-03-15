<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Tag;

class IndexController extends AdminController
{
    public function __invoke()
    {
        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        $data['tags'] = Tag::take(ConstantHelper::$TOTAL_FOR_PAGE)->get();
        return view('admin.tags.index', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Список тегов';
    }
}
