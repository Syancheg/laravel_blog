<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallary extends Model
{
    use HasFactory;

    protected $table = 'image_gallary';
    protected $guarded = false;

    public function images()
    {
        return $this->hasMany(GallaryFile::class, 'image_gallary_id', 'id');
    }

    public function mainImage()
    {
        return $this->hasOne(File::class, 'id', 'image');
    }
}
