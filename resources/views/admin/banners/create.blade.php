@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ url()->previous() }}" class="btn btn-default">назад</a>
            </div>
            <form action="{{ route('admin.banner.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title" class="required">Заголовок</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок">
                        @error('name')
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Сохранить</button>
                </div>
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
