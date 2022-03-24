<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GallaryFile extends Model
{
    use HasFactory;

    protected $table = 'image_gallary_file';
    protected $guarded = false;

    public function imageSource(){
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
