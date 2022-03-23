<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    protected $table = 'dogs';
    protected $guarded = false;

    public function childrens() {
        return $this->hasMany(DogDog::class, 'parent_id', 'id');
    }

    public function parents() {
        return $this->hasMany(DogDog::class, 'children_id', 'id');
    }

    public function achievments(){
        return $this->hasMany(DogAchievements::class, 'dog_id', 'id');
    }

    public function mainImage()
    {
        return $this->belongsTo(File::class, 'image', 'id');
    }
}
