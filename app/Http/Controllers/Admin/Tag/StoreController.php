<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\Tag\StoreRequest;
use App\Models\Tag;

class StoreController extends AdminController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        Tag::firstOrCreate($data);
        return redirect()->route('admin.tag.index');
    }
}
