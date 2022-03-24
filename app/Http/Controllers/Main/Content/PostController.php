<?php

namespace App\Http\Controllers\Main\Content;

use App\Helpers\BlogWidgetHelper;
use App\Http\Controllers\Main\MainController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends MainController
{

    private $categoryId;
    private $post;

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(Category $category, Post $post)
    {
        $this->setupWidgets();
        $this->getRandomPosts();
        $this->categoryId = $category->id;
        $this->post = $post;
        $this->data['tags'] = $post->post_tags;
        $data = $this->data;
        $data['post'] = $post;
        return view('main.content.post', compact('data'));
    }

    private function setupWidgets() {
        $widgetHelper = new BlogWidgetHelper();
        $this->data['categories'] = $widgetHelper->getCategories();
        $this->data['top_posts'] = $widgetHelper->getTopPosts($this->categoryId);
        $this->data['last_gallary'] = $widgetHelper->getLastGallary();
    }

    private function getRandomPosts() {
        $posts = Post::where(['active' => 1])->get();
        $this->data['additional_posts']['prev'] = $posts[rand(1, $posts->count())];
        $this->data['additional_posts']['next'] = $posts[rand(1, $posts->count())];
    }
}
