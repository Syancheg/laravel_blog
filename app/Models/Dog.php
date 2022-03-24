<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    protected $table = 'dogs';
    protected $guarded = false;
    protected $appends = [
        'current_gallaries_id',
        'father_id',
        'mother_id'
    ];

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

    public function gallaries() {
        return $this->hasMany(EntityGallary::class, 'entity_id', 'id');
    }

    public function getCurrentGallariesIdAttribute() {
        $gallaries = $this->gallaries->where('type', config('constants.dogs_type'));
        $arrId = [];
        foreach ($gallaries as $gallary) {
            $arrId[] = $gallary->gallary_id;
        }
        return $arrId;
    }

    public function getFatherIdAttribute() {
        foreach ($this->parents as $parent) {
            if($parent->parent_gender){
                return $parent->parent_id;
            }
        }
    }

    public function getMotherIdAttribute() {
        foreach ($this->parents as $parent) {
            if(!$parent->parent_gender){
                return $parent->parent_id;
            }
        }
    }
}
