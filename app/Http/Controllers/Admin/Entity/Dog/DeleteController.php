<?php

namespace App\Http\Controllers\Admin\Entity\Dog;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Dog;
use App\Models\EntityGallary;
use Illuminate\Http\Request;

class DeleteController extends AdminController
{
    public function __invoke(Dog $dog)
    {
        EntityGallary::where([
            'entity_id' => $dog->id,
            'type' => config('constants.dogs_type')
        ])->delete();
        $dog->delete();
        return redirect()->route('admin.entity.dog.index');
    }
}
