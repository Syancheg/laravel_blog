<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogAchievements extends Model
{
    use HasFactory;

    protected $table = 'dogs_achievements';
    protected $guarded = false;
    protected $appends = ['format_date'];

    public function getFormatDateAttribute() {
        $date = $this->date_receiving;
        if(!is_null($date)) {
            $date = explode('-', $date);
            $date = array_reverse($date);
            $date = implode('.', $date);
        }
        return $date;
    }
}


