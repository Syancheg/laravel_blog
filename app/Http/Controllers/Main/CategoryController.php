<?php

namespace App\Http\Controllers\Main;

use App\Helpers\ConstantHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\Common\MainMenuController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $staticData;

    public function __construct()
    {
        $this->staticData = [
            'layout' => [
            'main_menu' => MainMenuController::getMenu(),
            'styles' => ConstantHelper::$CATEGORY_STYLES,
            'scripts' => ConstantHelper::$CATEGORY_SCRIPTS
            ],
            'categories' => Category::all()
        ];
    }

    public function __invoke()
    {
        $data = $this->staticData;
        $data['posts'] = Post::take(20)->get();
        return view('main.category', compact('data'));
    }

    public function getCategory($slug){
        $category = Category::where('slug', $slug)->get();
        if(!$category->count()) {
            return redirect('404');
        }
        $data = $this->staticData;
        $data['category'] = $category[0];
        $data['posts'] = Post::where('category_id', $category[0]->id)->take(10)->get();
        return view('main.category', compact('data'));
    }
}
