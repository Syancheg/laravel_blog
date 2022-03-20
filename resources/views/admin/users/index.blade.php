@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
    <!-- Main content -->
    <section class="content">
        <input type="hidden" id="filemanage-ajax" value="{{ route('admin.filemanager.get') }}">
        <input type="hidden" id="user-edit-url" value="{{ route('admin.setting.user.edit') }}">
        <div class="container-fluid">
            <div class="col-4 mb-3">
                <button type="button"  onclick="openModalNewTag()" class="btn bg-gradient-success"><i class="fa fa-plus"></i></button>
            </div>
            <div class="col-12">
                @if(count($data['users']) > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Пользователи</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Аватар</th>
                                    <th>Имя</th>
                                    <th>Фамилия</th>
                                    <th>email</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['users'] as $user)
                                    <tr id="user-{{ $user->id }}" class="user-item-block">
                                        <td>
                                            {{ $user->id }}
                                        </td>
                                        <td class="user-image-cell">
                                            <div class="user-main-image" id="user_main_image-{{ $user->id }}" data-count="1">
                                                @if($user->image)
                                                    <div class="hover-image-block no_editable" data-type="user_main_image-{{ $user->id }}" data-id="{{ $data['category']->image }}">
                                                        <img src="{{ Storage::url($user->imagePath->path_origin) }}">
                                                        <input type="hidden" id="main_image" name="image_id" class="main_image-input" value="{{ $data['category']->image }}">
                                                    </div>
                                                @else
                                                    <div class="hover-image-block no_editable" data-type="user_main_image-{{ $user->id }}" data-id="0">
                                                        <img src="{{ Storage::url('public/noimg.png') }}">
                                                        <input type="hidden" id="main_image" name="image_id" class="main_image-input" value="">
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="user-cell">
                                            <input name="name" disabled value="{{ $user->name }}" class="form-control form-control-sm" type="text">
                                        </td>
                                        <td>
                                            <input name="surname" disabled value="{{ $user->surname }}" class="form-control form-control-sm" type="text">
                                        </td>
                                        <td>
                                            <input name="email" disabled value="{{ $user->email }}" class="form-control form-control-sm" type="email">
                                        </td>
                                        <td>
                                            <div class="action-button-block">
                                                <button type="submit" onclick="allowUserEditing({{ $user->id }}, event.currentTarget)" class="btn bg-gradient-primary" data-toggle="tooltip" data-placement="top" title="Изменить данные">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button type="submit" onclick="openModalChangePassword({{ $user->id }})" class="btn bg-gradient-warning" data-toggle="tooltip" data-placement="top" title="Сменить пароль">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                @if(count($data['users']) > 1)
                                                <button type="submit" onclick="deleteUser({{ $user->id }})" class="btn bg-gradient-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        {{ $data['users']->links('admin.include.pagination') }}
                    </div>
                @else
                    <div>
                        Тут пока нет ни одного пользователя
                    </div>
                @endif
            </div>
        </div><!-- /.container-fluid -->
        @include('admin.include.filemanager')
        @include('admin.users.modal_change_password', ['ajax' => $data['ajax']])
    </section>
    <!-- /.content -->
@endsection
