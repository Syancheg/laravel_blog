<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogAchievements extends Model
{
    use HasFactory;

    protected $table = 'dogs_achievements';
    protected $guarded = false;
    protected $appends = ['format_date'];

    public function getFormatDateAttribute() {
        return DateHelper::formatDateToDate($this->date_receiving);
    }
}


