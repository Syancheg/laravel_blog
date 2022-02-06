@extends('admin.layouts.main')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-12 mb-3 action-button-block">
            <a href="{{ route('admin.tag.edit', $tag->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
            <form action="{{ route('admin.tag.delete', $tag->id) }}" method="POST">
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
                    <td>{{ $tag->id }}</td>
                </tr>
                <tr>
                    <td>Наименование</td>
                    <td>{{ $tag->title }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection