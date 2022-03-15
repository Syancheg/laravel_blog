@extends('admin.layouts.main', ['breadcrumbs' => $breadcrumbs, 'headingTitle' => $headingTitle])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-12 mb-3 action-button-block">
            <a href="{{ route('admin.post.edit', $post->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
            <form action="{{ route('admin.post.delete', $post->id) }}" method="POST">
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
                    <td>ID</td>
                    <td>{{ $post->id }}</td>
                </tr>
                <tr>
                    <td>Наименование</td>
                    <td>{{ $post->title }}</td>
                </tr>
                <tr>
                    <td>Контент</td>
                    <td>{{ $post->content }}</td>
                </tr>
                <tr>
                    <td>Категория</td>
                    <td>{{ $post->category->title }}</td>
                </tr>
                <tr>
                    <td>Просмотры</td>
                    <td>{{ $post->views }}</td>
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
