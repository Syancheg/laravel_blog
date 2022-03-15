@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-12 mb-3 action-button-block">
            <a href="{{ route('admin.post.edit', $data['post']->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
            <form action="{{ route('admin.post.delete', $data['post']->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn bg-gradient-danger">
                    <i class="fas fa-trash-alt"></i>
                </button>

            </form>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td width="200px">ID</td>
                    <td>{{ $data['post']->id }}</td>
                </tr>
                <tr>
                    <td>Фото</td>
                    @if($data['post']->mainImage)
                        <td>
                            <div class="post-main-image">
                                <img src="{{ Storage::url($data['post']->mainImage->path_cache) }}">
                            </div>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td>Наименование</td>
                    <td>{{ $data['post']->title }}</td>
                </tr>
                <tr>
                    <td>Контент</td>
                    <td>{{ $data['post']->content }}</td>
                </tr>
                <tr>
                    <td>Категория</td>
                    <td>{{ $data['post']->category->title }}</td>
                </tr>
                <tr>
                    <td>Просмотры</td>
                    <td>{{ $data['post']->views }}</td>
                </tr>
                <tr>
                    <td>Комментарии</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
