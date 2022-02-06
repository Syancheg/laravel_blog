@extends('admin.layouts.main')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-12 mb-3">
            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>ID</td>
                    <td>{{ $category->id }}</td>
                </tr>
                <tr>
                    <td>Наименование</td>
                    <td>{{ $category->title }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection