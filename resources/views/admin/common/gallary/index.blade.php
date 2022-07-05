@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-4 mb-3">
                <a href="{{ route('admin.gallary.create') }}" class="btn bg-gradient-success"><i class="fas fa-plus"></i></a>
            </div>
            <div class="col-12">
                @if(count($data['gallaries']) > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Категории</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th style="width: 60%">Наименование</th>
                                    <th style="width: 15%">Количество изображений</th>
                                    <th style="width: 15%">Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['gallaries'] as $gallary)
                                    <tr>
                                        <td>{{ $gallary->id }}</td>
                                        <td>{{ $gallary->name }}</td>
                                        <td><span class="badge bg-danger">{{ count($gallary->images) }}</span></td>
                                        <td>
                                            <div class="action-button-block">
                                                <a href="{{ route('admin.gallary.edit', $gallary->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
                                                <a href="{{ route('admin.gallary.copy', $gallary->id) }}" class="btn bg-gradient-warning"><i class="fas fa-copy"></i></a>
                                                <form action="{{ route('admin.gallary.delete', $gallary->id) }}" method="POST">
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
                        {{ $data['gallaries']->links('admin.include.pagination') }}
                    </div>
                @else
                    <div>
                        Тут пока нет ни одной категории
                    </div>
                @endif
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
