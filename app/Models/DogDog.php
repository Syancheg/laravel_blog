<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogDog extends Model
{
    use HasFactory;

    protected $table = 'dog_dogs';
    protected $guarded = false;
    protected $appends = ['parent_gender'];

    public function getParentGenderAttribute() {
        $dog = Dog::find($this->parent_id);
        return $dog->gender;
    }
}
