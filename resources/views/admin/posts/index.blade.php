@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-4 mb-3">
            <a href="{{ route('admin.post.create') }}" class="btn bg-gradient-success"><i class="fas fa-plus"></i></a>
            <button type="button" class="btn bg-gradient-primary"><i class="fas fa-copy"></i></button>
            <button type="button" class="btn bg-gradient-danger"><i class="fas fa-trash-alt"></i></button>
        </div>
        <div class="col-12">
            @if(count($data['posts']) > 0)
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
                            <th style="width: 5%">Фото</th>
                            <th style="width: 60%">Наименование</th>
                            <th style="width: 5%">Категория</th>
                            <th style="width: 5%">Просмотры</th>
                            <th style="width: 5%">Комментарии</th>
                            <th style="width: 15%">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['posts'] as $post)

                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>
                                    @if($post->mainImage)
                                        <div class="post-list-image">
                                            <img src="{{ Storage::url($post->mainImage->path_origin) }}">
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category->title }}</td>
                                <td class="text-center">
                                    @if ($post->views < 10)
                                        <span class="badge bg-danger">
                                    @elseif ($post->views < 100)
                                        <span class="badge bg-warning">
                                    @elseif ($post->views > 100)
                                        <span class="badge bg-success">
                                    @endif
                                        {{ $post->views }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">5</span>
                                </td>
                                <td>
                                    <div class="action-button-block">
                                        <a href="{{ route('admin.post.show', $post->id) }}" class="btn bg-gradient-success"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.post.edit', $post->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('admin.post.delete', $post->id) }}" method="POST">
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
                    Тут пока нет ни одного поста
                </div>
            @endif
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
