<?php

namespace App\Http\Controllers\Main\Content;

use App\Helpers\BlogWidgetHelper;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Main\MainController;
use App\Models\Category;
use App\Models\ImagesCache;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends MainController
{
    private $post;
    private $category;
    private $imageHelper;

    public function __construct()
    {
        $this->setupData();
        $this->imageHelper = new ImageHelper();
    }

    public function __invoke(Category $category, Post $post)
    {
        $this->post = $post;
        $this->category = $category;

        $this->setupWidgets();
        $this->getRandomPosts();
        $this->setupCacheMainImage();
        $this->getBreadcrumbs();

        $this->data['tags'] = $this->post->post_tags;
        $this->data['post'] = $this->post;
        $data = $this->data;
        $this->addViewPost();
//        $this->post->update(['views' => $this->post->views++]);
//        dd($this->post->views + 1);
        return view('main.content.post', compact('data'));
    }

    private function setupCacheMainImage() {
        $resolution = [
            'width' => config('constants.post_main_width'),
            'height' => config('constants.post_main_height')
        ];
        $cachePath = $this->imageHelper->getImageCache($this->post->main_image, $resolution);
        $this->post->setAttribute('image_path', $cachePath);
    }

    private function setupWidgets() {
        $widgetHelper = new BlogWidgetHelper();
        $this->data['categories'] = $widgetHelper->getCategories();
        $this->data['top_posts'] = $widgetHelper->getTopPosts($this->category->id);
        $this->data['last_gallary'] = $widgetHelper->getLastGallary();
    }

    private function getRandomPosts() {
        $posts = Post::where(['active' => 1])->get();
        $resolution = [
            'width' => config('constants.post_add_width'),
            'height' => config('constants.post_add_height')
        ];
        $this->data['additional_posts']['prev'] = $posts[rand(1, $posts->count() - 1)];
        $cachePath = $this->imageHelper->getImageCache($this->data['additional_posts']['prev']->main_image, $resolution);
        $this->data['additional_posts']['prev']->setAttribute('image_path', $cachePath);

        $this->data['additional_posts']['next'] = $posts[rand(1, $posts->count() - 1)];
        $cachePath = $this->imageHelper->getImageCache($this->data['additional_posts']['next']->main_image, $resolution);
        $this->data['additional_posts']['next']->setAttribute('image_path', $cachePath);
    }

    private function getBreadcrumbs() {
        $breadcrumbs = [
            [
                'title' => 'Главная',
                'href' => route('public.home.index'),
            ],
            [
                'title' => 'Блог',
                'href' => route('public.content.blog'),
            ],
            [
                'title' => $this->category->title,
                'href' => route('public.content.category', [$this->category->slug]),
            ],
            [
                'title' => $this->post->title,
                'href' => '',
            ]
        ];
        $this->data['breadcrumbs'] = $breadcrumbs;
    }

    private function addViewPost() {
        Post::find($this->post->id)->update(['views' => $this->post->views + 1]);
    }
}
