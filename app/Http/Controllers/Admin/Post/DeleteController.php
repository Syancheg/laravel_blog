<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;

class DeleteController extends AdminController
{
    public function __invoke(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.post.index');
    }
}
