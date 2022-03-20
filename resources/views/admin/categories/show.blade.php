@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-12 mb-3 action-button-block">
            <a href="{{ route('admin.category.edit', $data['category']->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
            <form action="{{ route('admin.category.delete', $data['category']->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" @if(count($data['category']->posts)) disabled @endif class="btn bg-gradient-danger">
                    <i class="fas fa-trash-alt"></i>
                </button>

            </form>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>ID</td>
                    <td>{{ $data['category']->id }}</td>
                </tr>
                <tr>
                    <td>Наименование</td>
                    <td>{{ $data['category']->title }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
