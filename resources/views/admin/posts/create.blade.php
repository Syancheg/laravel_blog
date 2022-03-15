@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div>
            <a href="#" class="btn btn-default">назад</a>
        </div>
        <form action="{{ route('admin.post.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title" class="required">Заголовок</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок">
                    @error('title')
                    <div class="text-danger">{{ $errors->first('title') }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="main-image">Главное изображение</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="main_image" class="custom-file-input" id="main-image">
                            <label class="custom-file-label" for="main-image">Выбрать изображение</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Загрузить</span>
                        </div>
                    </div>
                    @error('main_image')
                    <div class="text-danger">{{ $errors->first('main_image') }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="input-content" class="required">Контент</label>
                    <textarea id="summernote" name="content" id="input-content">

                    </textarea>
                    @error('content')
                    <div class="text-danger">{{ $errors->first('content') }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category-select" class="required">Категория</label>
                    <select class="custom-select rounded-5" id="category" name="category_id">
                        @foreach($data['categories'] as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="slug" class="required">Seo-URL</label>
                    <input type="text" class="form-control" id="slug" name="slug" placeholder="seo-url">
                    @error('slug')
                    <div class="text-danger">{{ $errors->first('slug') }}</div>
                    @enderror
                </div>
                <input type="hidden" name="views" value="0">
                <div class="form-group">
                    <label for="seo_title">Заголовок страницы</label>
                    <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Заголовок страницы">
                </div>
                <div class="form-group">
                    <label for="seo_description">Описание страницы</label>
                    <input type="text" class="form-control" id="seo_description" name="seo_description" placeholder="Описание страницы">
                </div>
                <div class="form-group">
                    <label for="seo_keywords">Ключевые слова</label>
                    <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" placeholder="Ключевые слова">
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
