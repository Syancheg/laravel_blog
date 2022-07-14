@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-4 mb-3">
                <a href="{{ route('admin.entity.dog.create') }}" class="btn bg-gradient-success"><i class="fas fa-plus"></i></a>
            </div>
            <div class="col-12">
                @if(count($data['dogs']) > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Собаки</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Фото</th>
                                    <th>Имя</th>
                                    <th>Пол</th>
                                    <th>Дата рождения</th>
                                    <th>Активность</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['dogs'] as $dog)
                                    <tr>
                                        <td>{{ $dog->id }}</td>
                                        <td>
                                            @if($dog->image)
                                                <div class="post-list-image">
                                                    <img src="{{ Storage::url($dog->mainImage->path_origin) }}">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $dog->name }}</td>
                                        <td class="text-center">
                                            @if($dog->gender)
                                                Мужской
                                            @else
                                                Женский
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $dog->birthday }}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input onchange="activateDogs()" type="checkbox" @if($dog->active) checked @endif name="switch-active-{{ $dog->id }}" class="custom-control-input" id="active-switch-{{ $dog->id }}">
                                                <label class="custom-control-label" for="active-switch-{{ $dog->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-button-block">
                                                <a href="{{ route('admin.entity.dog.show', $dog->id) }}" class="btn bg-gradient-success"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('admin.entity.dog.edit', $dog->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
                                                <form action="{{ route('admin.entity.dog.delete', $dog->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn bg-gradient-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>

                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        {{ $data['dogs']->links('admin.include.pagination') }}
                    </div>
                @else
                    <div>
                        Тут пока нет ни одной собаки
                    </div>
                @endif
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
