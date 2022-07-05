<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends AdminController
{
    private $filter;
    private $sort;
    private $request;

    public function __construct()
    {
        $this->setupData();
        $this->data['tootle_active_url'] = route('admin.post.tootle-active');
    }

    public function __invoke(Request $request)
    {
        $this->request = $request;
//        dd($request);
//        dd($request->has('page'));
        $this->getAllCategories();
        $this->getFilterImageList();
        $this->getFilterActiveList();
        $this->getPosts();
//        dd($this->data);
        $data = $this->data;
        return view('admin.posts.index', compact('data'));
    }

    private function getPosts() {
//        dd($request->start);
        $allowed = ['id', 'title', 'active', 'views', 'category_id'];
        $sort = in_array($this->request->sort, $allowed) ? $this->request->sort : 'id';
        $order = $this->request->order === 'asc' ? 'asc' : 'desc';

        $posts = Post::orderBy($sort, $order);

        $filterImage = null;
        $filterTitle = null;
        $filterCategory = null;
        $filterActive = null;

        if($this->request->has('id')) {
            $posts->where(['id' => $this->request->get('id')]);
        }

        if($this->request->has('filter_title')) {
            $posts->where('title', 'LIKE', '%' . $this->request->get('filter_title') . '%');
            $filterTitle = $this->request->get('filter_title');
        }

        if($this->request->has('filter_image')) {
            if($this->request->filter_image){
                $posts->where('main_image', '!=', null);
            } else {
                $posts->where('main_image', '=', null);
            }
            $filterImage = $this->request->filter_image;
        }

        if($this->request->has('filter_category')) {
            $posts->where(['category_id' => $this->request->get('filter_category')]);
            $filterCategory = $this->request->get('filter_category');
        }

        if($this->request->has('filter_active')) {
            $posts->where(['active' => $this->request->get('filter_active')]);
            $filterActive = $this->request->get('filter_active');
        }

        $this->data['posts'] = $posts->paginate(config('constants.total_for_page'));

        $icon = $order === 'desc' ? 'arrow-down-9-1' : 'arrow-down-1-9';
        $toogleOrder = $order === 'asc' ? 'desc' : 'asc';

        $sortId = [
            'order' => $toogleOrder,
            'sort' => 'id',
        ];

        $this->data['sort_id'] = [
            'href' => $this->data['posts']->appends(array_merge($this->request->query->all(), $sortId))->url($this->request->page),
            'icon' => $icon,
            'active' => $sort === 'id',
        ];

        $sortTitle = [
            'order' => $toogleOrder,
            'sort' => 'title',
        ];
        $this->data['sort_title'] = [
            'href' => $this->data['posts']->appends(array_merge($this->request->query->all(), $sortTitle))->url($this->request->page),
            'icon' => $icon,
            'active' => $sort === 'title',
        ];

        $sortActive = [
            'order' => $toogleOrder,
            'sort' => 'active',
        ];

        $this->data['sort_active'] = [
            'href' => $this->data['posts']->appends(array_merge($this->request->query->all(), $sortActive))->url($this->request->page),
            'icon' => $icon,
            'active' => $sort === 'active',
        ];

        $sortViews = [
            'order' => $toogleOrder,
            'sort' => 'views',
        ];

        $this->data['sort_views'] = [
            'href' => $this->data['posts']->appends(array_merge($this->request->query->all(), $sortViews))->url($this->request->page),
            'icon' => $icon,
            'active' => $sort === 'views',
        ];

        $this->data['filter_image'] = $filterImage;
        $this->data['filter_title'] = $filterTitle;
        $this->data['filter_category'] = $filterCategory;
        $this->data['filter_active'] = $filterActive;
//        dd($this->data);
    }

    private function getFilterImageList() {
        $this->data['filter_image_list'] = [
            'Нет',
            'Есть',
        ];
    }

    private function getFilterActiveList() {
        $this->data['filter_active_list'] = [
            'Отключено',
            'Включено',
        ];
    }

    public function toogleActive($id) {
        $post = Post::find($id);
        $post->active = !$post->active;
        $post->save();
    }
}
