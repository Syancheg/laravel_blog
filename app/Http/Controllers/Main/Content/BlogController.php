<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Main\MainController;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\BlogWidgetHelper;

class BlogController extends MainController
{

    private $categoryId = 0;

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(Category $category)
    {

        if($category->getAttributes()){
            $this->categoryId = $category->id;
        }
        $this->setupWidgets();
//        dd($this->data['last_gallary'][0]->images_src);
        $data = $this->data;
        return view('main.content.category', compact('data'));
    }

    private function setupWidgets() {
        $widgetHelper = new BlogWidgetHelper();
        $this->data['categories'] = $widgetHelper->getCategories();
        $this->data['tags'] = $widgetHelper->getTags();
        $this->data['top_posts'] = $widgetHelper->getTopPosts($this->categoryId);
        $this->data['last_gallary'] = $widgetHelper->getLastGallary();
        $this->data['posts'] = $widgetHelper->getPosts($this->categoryId);
    }
}
