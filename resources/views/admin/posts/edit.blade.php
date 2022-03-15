@extends('admin.layouts.main', ['breadcrumbs' => $breadcrumbs, 'headingTitle' => $headingTitle])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div>
            <a href="#" class="btn btn-default">назад</a>
        </div>
        <ul>
            @foreach ($errors->all() as $index => $error)
                <li>{{ $index }}</li>
            @endforeach
        </ul>


        <form action="{{ route('admin.post.update', $post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="card-body">
                <div class="form-group">
                    <label for="title" class="required">Заголовок</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок" value="{{ $post->title }}">
                    @error('title')
                    <div class="text-danger">{{ $errors->first('title') }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="main-image">Главное изображение</label>
                    @if($post->mainImage)
                        <div class="post-main-image">
                            <img src="{{ Storage::url($post->mainImage->path_cache) }}">
                        </div>
                    @endif
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
                    <textarea id="summernote" name="content">
                        {{ $post->content }}
                    </textarea>
                    @error('content')
                    <div class="text-danger">{{ $errors->first('content') }} </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="category-select" class="required">Категория</label>
                    <select class="custom-select rounded-5" id="category" name="category_id">
                        @foreach($categories as $category)
                            @if ($category->id === $post->category_id)
                                <option selected value="{{ $category->id }}">{{ $category->title }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="views" value="{{ $post->views }}">
                <input type="hidden" name="views" value="0">
                <div class="form-group">
                    <label for="seo_title">Заголовок страницы</label>
                    <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Заголовок страницы" value="{{ $seo->seo_title ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="seo_description">Описание страницы</label>
                    <input type="text" class="form-control" id="seo_description" name="seo_description" placeholder="Описание страницы" value="{{ $seo->seo_description ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="seo_keywords">Ключевые слова</label>
                    <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" placeholder="Ключевые слова" value="{{ $seo->seo_keywords ?? '' }}">
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
