<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Tag;

class DeleteController extends AdminController
{
    public function __invoke(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tag.index');
    }
}
