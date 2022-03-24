<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $guarded = false;
    protected $appends = ['has_posts'];

    public function posts()
    {
        return $this->hasMany(PostTag::class);
    }

    public function getHasPostsAttribute() {
        $postsTag = PostTag::where(['tag_id' => $this->id])->get();
        foreach ($postsTag as $postTag) {
            $post = Post::where(['id' => $postTag->post_id, 'active' => 1])->first();
            if(!is_null($post)) {
                return true;
            }
        }
        return false;
    }
}
