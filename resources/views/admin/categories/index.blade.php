@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-4 mb-3">
            <a href="{{ route('admin.category.create') }}" class="btn bg-gradient-success"><i class="fas fa-plus"></i></a>
            <button type="button" class="btn bg-gradient-primary"><i class="fas fa-copy"></i></button>
            <button type="button" class="btn bg-gradient-danger"><i class="fas fa-trash-alt"></i></button>
        </div>
        <div class="col-12">
            @if(count($data['categories']) > 0)
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
                            <th style="width: 5%">Кол-во постов</th>
                            <th style="width: 15%">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['categories'] as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->title }}</td>
                                <td><span class="badge bg-danger">{{ count($category->posts) }}</span></td>
                                <td>
                                    <div class="action-button-block">
                                        <a href="{{ route('admin.category.show', $category->id) }}" class="btn bg-gradient-success"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.category.edit', $category->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('admin.category.delete', $category->id) }}" method="POST">
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
                    Тут пока нет ни одной категории
                </div>
            @endif
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
