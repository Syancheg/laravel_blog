<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Admin\AdminController;

class CreateController extends AdminController
{
    public function __invoke()
    {
        $data['layout']['heading_title'] = $this->getHeadingTitle();
        $data['layout']['breadcrumbs'] = $this->getBreadcrumbs();
        return view('admin.tags.create', compact('data'));
    }

    private function getHeadingTitle() {
        return 'Создание нового тега';
    }
}
