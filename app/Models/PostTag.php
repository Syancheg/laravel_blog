<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'tag_id',
    ];
//    protected $appends = ['post'];
//
//    public function getPostAttribute() {
//        return Post::where(['id' => $this->post_id, 'active' => 1])->first();
//    }


}
