@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div>
            <a href="{{ route('admin.post.index') }}" class="btn btn-default">назад</a>
        </div>
        <form action="{{ route('admin.post.update', $data['post']->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="card-body">
                <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input type="checkbox" name="active" class="custom-control-input" id="active-switch" value="{{ $data['post']->active }}">
                        <label class="custom-control-label" for="active-switch">Видимость</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="required">Заголовок</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок" value="{{ $data['post']->title }}">
                    @error('title')
                    <div class="text-danger">{{ $errors->first('title') }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="main-image">Главное изображение</label>
                    @if($data['post']->mainImage)
                        <div class="post-main-image">
                            <img src="{{ Storage::url($data['post']->mainImage->path_cache) }}">
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
                        {{ $data['post']->content }}
                    </textarea>
                    @error('content')
                    <div class="text-danger">{{ $errors->first('content') }} </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="category-select" class="required">Категория</label>
                    <select class="custom-select rounded-5" id="category" name="category_id">
                        @foreach($data['categories'] as $category)
                            @if ($category->id === $data['post']->category_id)
                                <option selected value="{{ $category->id }}">{{ $category->title }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="slug" class="required">Seo-URL</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $data['post']->slug }}">
                    @error('slug')
                    <div class="text-danger">{{ $errors->first('slug') }}</div>
                    @enderror
                </div>
                <input type="hidden" name="views" value="{{ $data['post']->views }}">
                <input type="hidden" name="views" value="0">
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
                    <input type="hidden" name="tags" id="tags-input" value="{{ $data['post']->tags }}">
                    @if(isset($data['cur_tags']))
                        <div class="tags-block" id="current-tags">
                            @foreach($data['cur_tags'] as $tag)
                                <div class="tag-item bg-success"  data-status="cur" data-id="{{ $tag->id }}">
                                    {{ $tag->title }}
                                </div>
                            @endforeach
                        </div>
                    @endif
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
