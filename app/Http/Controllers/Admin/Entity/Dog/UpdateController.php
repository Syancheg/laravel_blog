<?php

namespace App\Http\Controllers\Admin\Entity\Dog;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Entity\Dog\UpdateRequest;
use App\Models\Dog;
use App\Models\DogAchievements;
use App\Models\DogDog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UpdateController extends AdminController
{
    private $dog;
    private $validated;

    public function __construct()
    {
        $this->setupData();
    }

    public function __invoke(UpdateRequest $request, Dog $dog)
    {

        $this->validated = $request->validated();
        $this->validated['active'] = isset($this->validated['active']);
        $this->dog = $dog;
        $this->saveFather();
        $this->saveMother();
        $this->saveAchievements();
//        dd($this->validated);
        $this->saveDog();
        return redirect()->route('admin.entity.dog.index');
    }

    private function saveDog() {
        $this->dog->update($this->validated);
    }

    private function saveFather() {
        if(!is_null($this->validated['father'])) {
            if($this->isCurrentParent($this->validated['father'])) {
                unset($this->validated['father']);
                return;
            }
            if($relation = $this->getOldFather()){
                $relation->delete();
            }
            $data = [
                'parent_id' => $this->validated['father'],
                'children_id' => $this->dog->id
            ];
            DogDog::firstOrCreate($data);
        }
        unset($this->validated['father']);
    }

    private function saveMother() {
        if(!is_null($this->validated['mother'])) {
            if($this->isCurrentParent($this->validated['mother'])) {
                unset($this->validated['mother']);
                return;
            }
            if($relation = $this->getOldMother()){
                $relation->delete();
            }
            $data = [
                'parent_id' => $this->validated['mother'],
                'children_id' => $this->dog->id
            ];
            DogDog::firstOrCreate($data);
        }
        unset($this->validated['mother']);
    }

    private function saveAchievements() {
//        dd($this->validated['achievements']);
        if(isset($this->validated['achievements'])){
            $oldAchievements = DogAchievements::where(['dog_id' => $this->dog->id])->get('id')->toArray();
            if($oldAchievements){
                $oldAchievements = array_map(function ($item){
                    return (string)$item['id'];
                },$oldAchievements);
                $newAchievements = array_map(function ($item){
                    if(isset($item['id'])) {
                        return (string)$item['id'];
                    }

                },$this->validated['achievements']);
                $deleteAchievements = array_diff($oldAchievements, $newAchievements);
                $this->deleteOldAchievements($deleteAchievements);
            }
            foreach ($this->validated['achievements'] as $achievement) {
                $data = [
                    'name' => $achievement['name'],
                    'date_receiving' => $achievement['date'],
                    'dog_id' => $this->dog->id
                ];
                DogAchievements::firstOrCreate($data);
            }
        } else {
            DogAchievements::where(['dog_id' => $this->dog->id])->delete();
        }
        unset($this->validated['achievements']);
    }

    private function deleteOldAchievements($ids) {
        foreach ($ids as $id) {
            DogAchievements::where(['id' => $id])->delete();
        }
    }

    private function isCurrentParent($parent_id) {
        return DogDog::where(['parent_id' => $parent_id, 'children_id' => $this->dog->id])->get()->count() > 0;
    }

    private function getOldFather() {
        $parents = DogDog::where(['children_id' => $this->dog->id])->get();
        if($parents->count()) {
            foreach ($parents as $parent) {
                if($parent->parent_gender) {
                    return $parent;
                }
            }
        }
        return false;
    }

    private function getOldMother() {
        $parents = DogDog::where(['children_id' => $this->dog->id])->get();
        if($parents->count()) {
            foreach ($parents as $parent) {
                if(!$parent->parent_gender) {
                    return $parent;
                }
            }
        }
        return false;
    }

}
