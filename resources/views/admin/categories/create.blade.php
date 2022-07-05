@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div>
            <a href="{{ url()->previous() }}" class="btn btn-default">назад</a>
        </div>
        <form action="{{ route('admin.category.store') }}" method="post">
            @csrf
            <div class="card-body">
                <input type="hidden" name="active" value="0">
                <input type="hidden" id="filemanage-ajax" value="{{ route('admin.filemanager.get') }}">
                <div class="form-group">
                    <label for="title" class="required">Заголовок</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок">
                    @error('title')
                    <div class="text-danger">{{ $errors->first('title') }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="main_image">Миниатюра</label>
                    <div class="post-main-image" id="category_main_image" data-count="1">
                        <div class="hover-image-block" data-type="category_main_image" data-id="0">
                            @if(old('image'))
                                <img src="{{ Storage::url(old('image_src')) }}">
                            @else
                                <img src="{{ Storage::url('public/noimg.png') }}">
                            @endif
                            <input type="hidden" id="main_image" name="image" class="main_image-input" value="{{ old('image') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="banner_image">Баннер</label>
                    <div class="post-main-image" id="banner_image" data-count="1">
                        <div class="hover-image-block" data-type="banner_image" data-id="0">
                            @if(old('banner'))
                                <img src="{{ Storage::url(old('banner_src')) }}">
                            @else
                                <img src="{{ Storage::url('public/noimg.png') }}">
                            @endif
                            <input type="hidden" id="banner_image" name="banner" class="main_image-input" value="{{ old('banner') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="input-content">Контент</label>
                    <textarea id="summernote" name="content" id="input-content">

                    </textarea>
                    @error('content')
                    <div class="text-danger">{{ $errors->first('content') }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="title" class="required">Seo-URL</label>
                    <input type="text" class="form-control" id="title" name="slug" placeholder="Seo-URL">
                    @error('slug')
                    <div class="text-danger">{{ $errors->first('slug') }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="seo_title">Заголовок страницы</label>
                    <input value="{{old('seo_title')}}" type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Заголовок страницы">
                </div>
                <div class="form-group">
                    <label for="seo_description">Описание страницы</label>
                    <input value="{{old('seo_description')}}" type="text" class="form-control" id="seo_description" name="seo_description" placeholder="Описание страницы">
                </div>
                <div class="form-group">
                    <label for="seo_keywords">Ключевые слова</label>
                    <input value="{{old('seo_keywords')}}" type="text" class="form-control" id="seo_keywords" name="seo_keywords" placeholder="Ключевые слова">
                </div>
                <div class="form-group">
                    <label for="tags">Теги</label>
                    <input type="hidden" name="tags" id="tags-input" value="">
                    <div class="tags-block" id="current-tags">
                    </div>
                    @if(isset($data['tags']))
                        <div class="tags-block" id="all-tags">
                            @foreach($data['tags'] as $tag)
                                <div class="tag-item bg-warning" data-status="new" data-id="{{ $tag->id }}">
                                    {{ $tag->title }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div><!-- /.container-fluid -->

    @include('admin.include.filemanager')
</section>
<!-- /.content -->
@endsection
