<?php

namespace App\Http\Controllers\Admin\Entity\Dog;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Entity\Dog\StoreRequest;
use App\Models\Dog;
use App\Models\DogAchievements;
use App\Models\DogDog;
use App\Models\EntityGallary;

class StoreController extends AdminController
{
    private $dog;
    private $validated;

    public function __invoke(StoreRequest $request)
    {
        $this->validated = $request->validated();
        $this->saveDog();
        $this->saveFather();
        $this->saveMother();
        $this->saveAchievements();
        $this->saveGallaries();
        return redirect()->route('admin.entity.dog.index');
    }

    private function saveDog() {
        $this->dog = new Dog();
        $this->dog->name = $this->validated['name'];
        $this->dog->gender = $this->validated['gender'];
        $this->dog->text = $this->validated['text'];
        $this->dog->image = $this->validated['image'];
        $this->dog->birthday = $this->validated['birthday'];
        $this->dog->active = $this->validated['active'];
        $this->dog->save();
    }

    private function saveFather() {
        if(!is_null($this->validated['father'])) {
            $data = [
                'parent_id' => $this->validated['father'],
                'children_id' => $this->dog->id
            ];
            DogDog::firstOrCreate($data);
        }
    }

    private function saveMother() {
        if(!is_null($this->validated['mother'])) {
            $data = [
                'parent_id' => $this->validated['mother'],
                'children_id' => $this->dog->id
            ];
            DogDog::firstOrCreate($data);
        }
    }

    private function saveAchievements() {
        if(isset($this->validated['achievements'])){
            foreach ($this->validated['achievements'] as $achievement) {
                $data = [
                    'name' => $achievement['name'],
                    'date_receiving' => $achievement['date'],
                    'dog_id' => $this->dog->id
                ];
                DogAchievements::firstOrCreate($data);
            }
        }
    }

    private function saveGallaries() {
        if(isset($this->validated['gallaries'])) {
            foreach ($this->validated['gallaries'] as $gallary) {
                $data = [
                    'entity_id' => $this->dog->id,
                    'gallary_id' => $gallary,
                    'type' => config('constants.dogs_type')
                ];
                EntityGallary::firstOrCreate($data);
            }
        }
    }

}
