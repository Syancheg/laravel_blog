@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-4 mb-3">
            <a href="{{ route('admin.tag.create') }}" class="btn bg-gradient-success"><i class="fas fa-plus"></i></a>
            <button type="button" class="btn bg-gradient-primary"><i class="fas fa-copy"></i></button>
            <button type="button" class="btn bg-gradient-danger"><i class="fas fa-trash-alt"></i></button>
        </div>
        <div class="col-12">
            @if(count($data['tags']) > 0)
             <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Теги</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 60%">Наименование</th>
                            <th style="width: 5%">Кол-во постов</th>
                            <th style="width: 15%">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['tags'] as $tag)
                            <tr>
                                <td>{{ $tag->id }}</td>
                                <td>{{ $tag->title }}</td>
                                <td><span class="badge bg-danger">2</span></td>
                                <td>
                                    <div class="action-button-block">
                                        <a href="{{ route('admin.tag.show', $tag->id) }}" class="btn bg-gradient-default"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.tag.edit', $tag->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('admin.tag.delete', $tag->id) }}" method="POST">
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
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">«</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
                </div>
            </div>
            @else
                <div>
                    Тут пока нет ни одного тега
                </div>
            @endif
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
