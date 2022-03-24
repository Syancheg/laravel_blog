<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoDescription extends Model
{
    use HasFactory;

    protected $table = 'seo_descriptions';
    protected $guarded = false;
}
