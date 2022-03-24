<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\User\EditPasswordRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateController extends AdminController
{
    private $user;

    function changePassword(EditPasswordRequest $request, $id) {
        $validated = $request->validated();
        $hash['password'] = Hash::make($validated['password']);
        if (User::find($id)->update($hash)) {
            return response()->json(['success' => 'Пароль пользователя успешно изменен!']);
        } else {
            $error['password'][0] = 'По неизвестной причине не удалось сохранить пароль';
            return response()->json(['errors' => $error], 422);
        }
    }

    function editUser(UpdateRequest $request, $id) {
        $validated = $request->validated();
//        return $validated;
        if (User::find($id)->update($validated)) {
            $response['success'] = 'Данные пользователя успешно изменены';
            return response()->json($response);
        } else {
            $error['other'][0] = 'По неизвестной причине не удалось сохранить данные пользователя';
            return response()->json(['errors' => $error], 422);
        }
    }
}
