<?php


namespace App\Helpers;


use App\Models\Category;
use App\Models\File;
use App\Models\Gallary;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class BlogWidgetHelper
{

    public function getCategories() {
        $categories = Category::where(['active' => 1])->get();
        $collection = new Collection();
        if($categories->count() > 0) {
            foreach ($categories as $category) {
                if($category->postsActive->count() > 0) {
                    $collection->push($category);
                }
            }
        }
        return $collection;
    }

    public function getTags() {
        $tags = Tag::all();
        $collection = new Collection();
        if($tags->count() > 0) {
            foreach ($tags as $tag) {
                if($tag->has_posts) {
                    $collection->push($tag);
                }
            }
        }
        return $collection;
    }

    public function getTopPosts($categoryId = 0) {

        $posts = $categoryId
            ? Post::where(['active' => 1, 'category_id' => $categoryId])
                ->orderBy('views', 'DESC')
                ->take(4)
                ->get()
            : Post::join('categories', function($join) {
                $join
                    ->on('posts.category_id', '=', 'categories.id');
                })
                ->where(['posts.active' => 1, 'categories.active' => 1])
                ->orderBy('posts.views', 'DESC')
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
            : Post::join('categories', function($join) {
                $join
                    ->on('posts.category_id', '=', 'categories.id');
                })
                ->where(['posts.active' => 1, 'categories.active' => 1])
                ->orderBy('posts.created_at', 'DESC')
                ->paginate(config('constants.blog_total_posts'));
        if($posts->count() > 0) {
            $posts = $this->setupCachePostImage($posts, 'post_main');
        }
        return $posts;
    }

    public function getPostForTag($tag) {
        $postsId = PostTag::where(['tag_id' => $tag])->get()->toArray();
        if($postsId){
            $postsId = array_map(function($item) {
                return $item['post_id'];
            }, $postsId);
        } else {
            $postsId = [0];
        }
        $posts = Post::join('categories', function($join) {
            $join
                ->on('posts.category_id', '=', 'categories.id');
            })
            ->whereIn('posts.id', $postsId)
            ->where(['posts.active' => 1, 'categories.active' => 1])
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
