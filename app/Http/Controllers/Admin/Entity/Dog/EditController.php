<?php

namespace App\Http\Controllers\Admin\Entity\Dog;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Dog;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class EditController extends AdminController
{
    public $dog;

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(Dog $dog)
    {
        $this->data['back_lick'] = url()->previous();
        $this->data['dog'] = $dog;
        $this->getAllGallaries();
        $this->getDogsFemale();

//        dd($this->data['dog']->current_gallaries_id);
        $data = $this->data;
        return view('admin.entities.dogs.edit', compact('data'));
    }
    private function getDogsMale() {
        $this->data['dogs_male'] = Dog::where(['gender' => 1])
            ->where('id', '!=', $this->data['dog']->id)
            ->get();
    }

    private function getDogsFemale() {
        $this->data['dogs_female'] = Dog::where(['gender' => 0])
            ->where('id', '!=', $this->data['dog']->id)
            ->get();
        $this->getDogsMale();
    }

    public function activateDogs(Request $request, $id) {
        $dog = Dog::find($id);
        $dog->active = $request->input('status') === 'true' ? 1 : 0;
        return $dog->save();
    }


}
