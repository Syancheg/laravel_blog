<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;
use App\Models\PostTag;

class DeleteController extends AdminController
{
    public function __invoke(Post $post)
    {
        PostTag::where(['post_id' => $post->id])->delete();
        $post->delete();
        return redirect()->route('admin.post.index');
    }
}
