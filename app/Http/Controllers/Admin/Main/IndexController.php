<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Admin\AdminController;

class IndexController extends AdminController
{
    public function __invoke()
    {
        $headingTitle = $this->getHeadingTitle();
        $breadcrumbs = $this->getBreadcrumbs();
        return view('admin.main.index', compact(
            'breadcrumbs',
            'headingTitle'
        ));
    }

    private function getHeadingTitle() {
        return 'Главная';
    }
}
