<?php

namespace App\Http\Controllers\Admin\Entity\Dog;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Dog;
use App\Models\File;
use Illuminate\Support\Facades\Request;

class CreateController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke()
    {

        $session = Request::getSession();
//        dd($session);
        if($session->hasOldInput()){
            $oldInput = $session->getOldInput();
            $file = File::where(['id' => $oldInput['image']])->first();
            if($file) {
                $oldInput['image_src'] = $file->path_origin;
                $session->put('_old_input', $oldInput);
            }
        }
        $this->getDogsFemale();
        $this->getDogsMale();
        $data = $this->data;
        return view('admin.entities.dogs.create', compact('data'));
    }

    public function getDogsMale() {
        $this->data['dogs_male'] = Dog::where(['gender' => 1])->get();
    }

    public function getDogsFemale() {
        $this->data['dogs_female'] = Dog::where(['gender' => 0])->get();
    }
}
