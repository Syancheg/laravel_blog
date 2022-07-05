<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallary extends Model
{
    use HasFactory;

    protected $table = 'image_gallary';
    protected $guarded = false;
    protected $appends = [
        'format_date',
        'images_src',
        ];


    public function images()
    {
        return $this->hasMany(GallaryFile::class, 'image_gallary_id', 'id');
    }

    public function mainImage()
    {
        return $this->hasOne(File::class, 'id', 'image');
    }

    public function getFormatDateAttribute() {
        return DateHelper::formatDateTimeToDate($this->created_at);
    }

    public function getImagesSrcAttribute() {
        $imageArr = [];
        $gallaryFiles = $this->images;
        foreach ($gallaryFiles as $gallaryFile) {
            $file = File::find($gallaryFile->file_id);
            $imageArr[] = $file->path_origin;
        }
        return $imageArr;
    }
}
