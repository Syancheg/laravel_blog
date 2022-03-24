<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\AdminController;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends AdminController
{
    public function __construct()
    {
        $this->setupData();
        $this->data['ajax']['change_password_url'] = route('admin.setting.user.change-password');
    }

    public function __invoke()
    {
        $this->getUsers();
        $data = $this->data;
        return view('admin.users.index', compact('data'));
    }

    public function getUsers() {
        $this->data['users'] = User::paginate(config('constants.total_for_page'));
    }
}
