<?php


namespace App\Helpers;


use App\Models\Category;
use App\Models\Gallary;
use App\Models\Post;
use App\Models\Tag;

class BlogWidgetHelper
{

    public function getCategories() {
        return Category::where(['active' => 1])->get();
    }

    public function getTags() {
        return Tag::all();
    }

    public function getTopPosts($categoryId = 0) {

        return $categoryId
            ? Post::where(['active' => 1, 'category_id' => $categoryId])
                ->orderBy('views', 'DESC')
                ->take(4)
                ->get()
            : Post::where(['active' => 1])
                ->orderBy('views', 'DESC')
                ->take(4)
                ->get();
    }

    public function getLastGallary() {
        return Gallary::orderBy('created_at', 'DESC')->take(1)->get();
    }

    public function getPosts($categoryId = 0) {

        return $categoryId
            ? Post::where(['active' => 1, 'category_id' => $categoryId])
                ->orderBy('created_at', 'DESC')
                ->paginate(config('constants.blog_total_posts'))
            : Post::where(['active' => 1])
                ->orderBy('created_at', 'DESC')
                ->paginate(config('constants.blog_total_posts'));
    }

}
