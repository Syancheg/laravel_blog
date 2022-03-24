<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';
    protected $guarded = false;
    protected $appends = ['count_posts'];

    public function imagePath() {
        return $this->belongsTo(File::class, 'image', 'id');
    }

    public function bannerPath() {
        return $this->belongsTo(File::class, 'banner', 'id');
    }

    public function tags()
    {
        return $this->hasMany(CategoryTag::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function getCountPostsAttribute() {
        return Post::where(['category_id' => $this->id, 'active' => 1])->get()->count();
    }

}
