<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;

class IndexController extends AdminController
{

    public function __construct()
    {
        $this->setupData();
        $this->data['tootle_active_url'] = route('admin.post.tootle-active');
    }

    public function __invoke()
    {
        $this->getPosts();
        $data = $this->data;
        return view('admin.posts.index', compact('data'));
    }

    private function getPosts() {
        $this->data['posts'] = Post::take(config('constants.total_for_page'))->get();
    }

    public function toogleActive($id) {
        $post = Post::find($id);
        $post->active = !$post->active;
        $post->save();
    }
}
