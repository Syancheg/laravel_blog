<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'posts';
    protected $guarded = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function mainImage()
    {
        return $this->belongsTo(File::class, 'main_image', 'id');
    }
}
