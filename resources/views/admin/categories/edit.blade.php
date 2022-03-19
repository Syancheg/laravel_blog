@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div>
            <a href="{{ route('admin.category.index') }}" class="btn btn-default">назад</a>
        </div>
        <form action="{{ route('admin.category.update', $data['category']->id) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="card-body">
                <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input type="checkbox" @if($data['category']->active) checked @endif name="active" class="custom-control-input" id="active-switch">
                        <label class="custom-control-label" for="active-switch">Видимость</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="required">Заголовок</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок" value="{{ $data['category']->title }}">
                    @error('title')
                    <div class="text-danger">это поле необходимо </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_main_image">Миниатюра</label>
                    <div class="post-main-image" id="category_main_image" data-count="1">
                        @if($data['category']->image)
                            <div class="hover-image-block" data-type="category_main_image" data-id="{{ $data['category']->image }}">
                                <img src="{{ Storage::url($data['category']->imagePath->path_origin) }}">
                                <input type="hidden" id="main_image" name="image" class="main_image-input" value="{{ $data['category']->image }}">
                            </div>
                        @else
                            <div class="hover-image-block" data-type="post_main_image" data-id="0">
                                <img src="{{ Storage::url('public/noimg.png') }}">
                                <input type="hidden" id="main_image" name="image" class="main_image-input" value="">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="banner-image">Баннер</label>
                    <div class="post-main-image" id="banner_image" data-count="1">
                        @if($data['category']->banner)
                            <div class="hover-image-block" data-type="banner_image" data-id="{{ $data['category']->banner }}">
                                <img src="{{ Storage::url($data['category']->bannerPath->path_origin) }}">
                                <input type="hidden" id="banner_image" name="banner" class="main_image-input" value="{{ $data['category']->banner }}">
                            </div>
                        @else
                            <div class="hover-image-block" data-type="banner_image" data-id="0">
                                <img src="{{ Storage::url('public/noimg.png') }}">
                                <input type="hidden" id="banner_image" name="banner" class="main_image-input" value="">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="input-content" class="required">Контент</label>
                    <textarea id="summernote" name="content">
                        {{ $data['category']->content }}
                    </textarea>
                    @error('content')
                    <div class="text-danger">{{ $errors->first('content') }} </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slug" class="required">Seo-URL</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $data['category']->slug }}">
                    @error('slug')
                    <div class="text-danger">{{ $errors->first('slug') }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="seo_title">Заголовок страницы</label>
                    <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Заголовок страницы" value="{{ $data['seo']->seo_title ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="seo_description">Описание страницы</label>
                    <input type="text" class="form-control" id="seo_description" name="seo_description" placeholder="Описание страницы" value="{{ $data['seo']->seo_description ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="seo_keywords">Ключевые слова</label>
                    <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" placeholder="Ключевые слова" value="{{ $data['seo']->seo_keywords ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="tags">Теги</label>
                    <input type="hidden" name="tags" id="tags-input" value="{{ $data['category']->tags }}">
                    <div class="tags-block" id="current-tags">
                        @if(isset($data['cur_tags']))
                                @foreach($data['cur_tags'] as $tag)
                                    <div class="tag-item bg-success"  data-status="cur" data-id="{{ $tag->id }}">
                                        {{ $tag->title }}
                                    </div>
                                @endforeach
                        @endif
                    </div>
                    @if(isset($data['new_tags']))
                        <div class="tags-block" id="all-tags">
                            @foreach($data['new_tags'] as $tag)
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
                <button type="submit" class="btn btn-success">Обновить</button>
            </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
