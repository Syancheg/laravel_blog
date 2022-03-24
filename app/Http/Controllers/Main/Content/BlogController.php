<?php

namespace App\Http\Controllers\Main\Content;

use App\Http\Controllers\Main\MainController;
use App\Models\Category;
use App\Models\Gallary;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends MainController
{

    private $categoryId;

    public function __construct()
    {
        $this->setupData();
        $this->getCategories();
        $this->getTags();
        $this->getLastGallary();
    }

    public function __invoke(Category $category)
    {

        if($category->getAttributes()){
            $this->categoryId = $category->id;
        }
        $this->getTopPosts();
        $this->getPosts();
//        dd($this->data['last_gallary'][0]->images_src);
        $data = $this->data;
        return view('main.content.category', compact('data'));
    }

    private function getCategories() {
        $this->data['categories'] = Category::where(['active' => 1])->get();
    }

    private function getTags() {
        $this->data['tags'] = Tag::all();
    }

    private function getTopPosts() {

        $this->data['top_posts'] = is_null($this->categoryId)
            ? Post::where(['active' => 1])
                ->orderBy('views', 'DESC')
                ->take(4)
                ->get()
            : Post::where(['active' => 1, 'category_id' => $this->categoryId])
                ->orderBy('views', 'DESC')
                ->take(4)
                ->get();
    }

    private function getLastGallary() {
        $this->data['last_gallary'] = Gallary::orderBy('created_at', 'DESC')->take(1)->get();
    }

    private function getPosts() {

        $this->data['posts'] = is_null($this->categoryId)
            ? Post::where(['active' => 1])
                ->orderBy('created_at', 'DESC')
                ->paginate(config('constants.blog_total_posts'))
            : Post::where(['active' => 1, 'category_id' => $this->categoryId])
                ->orderBy('created_at', 'DESC')
                ->paginate(config('constants.blog_total_posts'));
    }
}
