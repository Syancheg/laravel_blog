<?php


namespace App\Helpers;


use App\Models\Category;
use App\Models\File;
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

        $posts = $categoryId
            ? Post::where(['active' => 1, 'category_id' => $categoryId])
                ->orderBy('views', 'DESC')
                ->take(4)
                ->get()
            : Post::where(['active' => 1])
                ->orderBy('views', 'DESC')
                ->take(4)
                ->get();
        if($posts->count() > 0) {
            $posts = $this->setupCachePostImage($posts, 'post_top');
        }
        return $posts;
    }

    public function getLastGallary() {
        $gallary = Gallary::orderBy('created_at', 'DESC')->first();
        if (!is_null($gallary)) {
            $this->setupCacheGallaryImages($gallary->images);
        }
        return $gallary;
    }

    public function getPosts($categoryId = 0) {
        $posts = $categoryId
            ? Post::where(['active' => 1, 'category_id' => $categoryId])
                ->orderBy('created_at', 'DESC')
                ->paginate(config('constants.blog_total_posts'))
            : Post::where(['active' => 1])
                ->orderBy('created_at', 'DESC')
                ->paginate(config('constants.blog_total_posts'));
        if($posts->count() > 0) {
            $posts = $this->setupCachePostImage($posts, 'post_main');
        }
        return $posts;
    }

    private function setupCachePostImage($posts, $type) {
        $resolution = [
            'width' => config('constants.' . $type . '_width'),
            'height' => config('constants.' . $type . '_height')
        ];
        $imageHelper = new ImageHelper();
        for ($i = 0; $i < $posts->count(); $i++) {
            $cachePath = $imageHelper->getImageCache($posts[$i]->main_image, $resolution);
            $posts[$i]->setAttribute('image_path', $cachePath);
        }
        return $posts;
    }

    private function setupCacheGallaryImages($images){
        $resolution = [
            'width' => config('constants.gallary_new_width'),
            'height' => config('constants.gallary_new_height')
        ];
        $imageHelper = new ImageHelper();
        for ($i = 0; $i < $images->count(); $i++) {
            $cachePath = $imageHelper->getImageCache($images[$i]->file_id, $resolution);
            $originPath = $imageHelper->getImageOrigin($images[$i]->file_id);
            $image = [
                'max' => $originPath,
                'min' => $cachePath
            ];
            $images[$i]->setAttribute('image_path', $image);
        }
        return $images;
    }

}
