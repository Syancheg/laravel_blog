<?php

namespace App\Http\Controllers\Admin\Entity\Dog;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Dog;
use Illuminate\Http\Request;

class EditController extends AdminController
{
    public $dog;

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(Dog $dog)
    {
        $this->dog = $dog;
        $this->getDog();
        $this->getSetupParentsId();
        $this->convertDate();
        $this->getDogsFemale();
        $this->getDogsMale();
        $data = $this->data;
        return view('admin.entities.dogs.edit', compact('data'));
    }

    private function getDog() {
        $this->data['dog'] = Dog::find($this->dog->id);
    }

    private function convertDate() {
        if(!is_null($this->data['dog']->birthday)) {
            $date = explode('-', $this->data['dog']->birthday);
            $date = array_reverse($date);
            $this->data['dog']->birthday_convert = implode('.', $date);
        }
    }

    private function getSetupParentsId() {
        if($this->data['dog']->parents->count()){
            foreach ($this->data['dog']->parents as $parent) {
                if($parent->parent_gender){
                    $this->data['dog']->father_id = $parent->parent_id;
                } else {
                    $this->data['dog']->mother_id = $parent->parent_id;
                }
            }
        }
    }

    public function getDogsMale() {
        $this->data['dogs_male'] = Dog::where(['gender' => 1])
            ->where('id', '!=', $this->data['dog']->id)
            ->get();
    }

    public function getDogsFemale() {
        $this->data['dogs_female'] = Dog::where(['gender' => 0])
            ->where('id', '!=', $this->data['dog']->id)
            ->get();
    }
}
