<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuForRoutes extends Model
{
    use HasFactory;

    protected $table = 'menu_titles_for_routes';
    protected $guarded = false;
}
