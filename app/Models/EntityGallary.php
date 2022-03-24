<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntityGallary extends Model
{
    use HasFactory;

    protected $table = 'entity_gallary';
    protected $guarded = false;

    protected $appends = ['gallary'];

    public function getGallaryAttribute() {
        return Gallary::find($this->gallary_id);
    }
}
