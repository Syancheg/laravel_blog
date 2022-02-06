<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SeoDescription;

class EditController extends Controller
{
    public function __invoke(Post $post)
    {
        $seo = SeoDescription::where(['type' => 1, 'item_id' => $post->id])->first();
        return view('admin.posts.edit', compact('post', 'seo'));
    }
}
