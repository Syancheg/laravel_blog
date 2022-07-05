<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Main\MainController;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Helpers\BlogWidgetHelper;

class BlogController extends MainController
{

    private $categoryId = 0;
    private $category;
    private $blogWidgetHelper;
    private $tag = 0;

    public function __construct()
    {
        $this->setupData();
        $this->blogWidgetHelper = new BlogWidgetHelper();
    }

    public function __invoke(Category $category)
    {

        if($category->getAttributes()){
            $this->categoryId = $category->id;
            $this->category = $category;
        }
        $this->setupWidgets();
        $this->getBreadcrumbs();
//        dd($this->data['last_gallary'][0]->images_src);
        $data = $this->data;
        return view('main.content.category', compact('data'));
    }

    public function getPostForTag(Tag $tag) {
        $this->tag = $tag;
        $this->setupWidgets($tag->id);
//        dd($this->data['posts']);
        $this->getBreadcrumbs();
//        dd($this->data['last_gallary'][0]->images_src);
        $data = $this->data;
        return view('main.content.category', compact('data'));
    }

    private function setupWidgets($tag = 0) {
        $this->data['categories'] = $this->blogWidgetHelper->getCategories();
        $this->data['tags'] = $this->blogWidgetHelper->getTags();
        $this->data['top_posts'] = $this->blogWidgetHelper->getTopPosts($this->categoryId);
        $this->data['last_gallary'] = $this->blogWidgetHelper->getLastGallary();
        $this->data['posts'] = $tag
            ? $this->blogWidgetHelper->getPostForTag($tag)
            : $this->blogWidgetHelper->getPosts($this->categoryId);
    }

    private function getBreadcrumbs() {
        $breadcrumbs = [
            [
                'title' => 'Главная',
                'href' => route('public.home.index'),
            ],
            [
                'title' => 'Блог',
                'href' => $this->categoryId ? route('public.content.blog') : '',
            ]
        ];
        if($this->tag){
            $breadcrumbs[] = [
                'title' => $this->tag->title,
                'href' => '',
            ];
        }
        if($this->categoryId) {
            $breadcrumbs[] = [
                'title' => $this->category->title,
                'href' => '',
            ];
        }
        $this->data['breadcrumbs'] = $breadcrumbs;
    }
}
