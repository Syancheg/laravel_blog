<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\DateHelper;
use App\Models\Category;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'posts';
    protected $guarded = false;
    protected $appends = [
        'format_date',
        'format_date_label',
        'post_tags',
        ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function mainImage()
    {
        return $this->belongsTo(File::class, 'main_image', 'id');
    }

    public function tags()
    {
        return $this->hasMany(PostTag::class);
    }

    public function getFormatDateAttribute() {
        return DateHelper::formatDateTimeToDate($this->created_at);
    }

    public function getFormatDateLabelAttribute() {
        return DateHelper::formatDateToPoblicPost($this->created_at);
    }

    public function getPostTagsAttribute() {
        $tagsId = array_map(function($item) {
            return $item['tag_id'];
        }, $this->tags->toArray());
       return Tag::find($tagsId);
    }
}
