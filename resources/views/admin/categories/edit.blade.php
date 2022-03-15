@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div>
            <a href="#" class="btn btn-default">назад</a>
        </div>
        <form action="{{ route('admin.category.update', $data['category']->id) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="card-body">
                <div class="form-group">
                    <label for="title" class="required">Заголовок</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок" value="{{ $data['category']->title }}">
                    @error('title')
                    <div class="text-danger">это поле необходимо </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug" class="required">Seo-URL</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $data['category']->slug }}">
                    @error('slug')
                    <div class="text-danger">{{ $errors->first('slug') }}</div>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Обновить</button>
            </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
