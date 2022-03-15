@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div>
            <a href="#" class="btn btn-default">назад</a>
        </div>
        <form action="{{ route('admin.tag.update', $data['tag']->id) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="card-body">
                <div class="form-group">
                    <label for="title" class="required">Заголовок</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок" value="{{ $data['tag']->title }}">
                    @error('title')
                    <div class="text-danger">{{ $errors->first('title') }}</div>
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
