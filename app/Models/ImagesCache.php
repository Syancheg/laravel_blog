<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesCache extends Model
{
    use HasFactory;

    protected $table = 'images_cache';
    protected $guarded = false;
}
