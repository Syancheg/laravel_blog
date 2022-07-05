@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-4 mb-3">
            <a href="{{ route('admin.post.create') }}" class="btn bg-gradient-success"><i class="fas fa-plus"></i></a>
        </div>
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.post.index') }}" id="filter" method="get">
                    <div class="card-header">
                        <h3 class="card-title">Фильтр</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="filter_image-select">Фото</label>
                                    <select class="custom-select rounded-5" id="filter_image-select" name="filter_image">
                                        <option value=""></option>
                                        @foreach($data['filter_image_list'] as $index => $item)
                                            <option @if($data['filter_image'] === (string)$index) selected @endif value="{{ $index }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input type="text" class="form-control"
                                           id="title"
                                           name="filter_title"
                                           @if(!is_null($data['filter_title']))
                                               value="{{ $data['filter_title'] }}"
                                           @endif
                                    >
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="filter_category-select">Категория</label>
                                    <select class="custom-select rounded-5" id="filter_category-select" name="filter_category">
                                        <option value=""></option>
                                        @foreach($data['categories'] as $category)
                                            @if($data['filter_category'] === (string)$category->id)
                                                <option selected value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endif
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="filter_active-select">Видимость</label>
                                    <select class="custom-select rounded-5" id="filter_active-select" name="filter_active">
                                        <option value=""></option>
                                        @foreach($data['filter_active_list'] as $index => $item)
                                            <option @if($data['filter_active'] === (string)$index) selected @endif value="{{ $index }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12">
            @if(count($data['posts']) > 0)
             <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Посты</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <input type="hidden" value="{{ $data['tootle_active_url'] }}" id="active-ajax-url">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 5%">
                                <div class="sorted-column">
                                    <span>ID</span>
                                    <a @if($data['sort_id']['active']) class="active" @endif href="{{ $data['sort_id']['href'] }}">
                                        <i class="fa fa-{{ $data['sort_id']['icon'] }}"></i>
                                    </a>
                                </div>
                            </th>
                            <th style="width: 5%">Фото</th>
                            <th style="width: 60%">
                                <div class="sorted-column">
                                    <span>Наименование</span>
                                    <a @if($data['sort_title']['active']) class="active" @endif href="{{ $data['sort_title']['href'] }}">
                                        <i class="fa fa-{{ $data['sort_title']['icon'] }}"></i>
                                    </a>
                                </div>
                            </th>
                            <th style="width: 5%">Категория</th>
                            <th style="width: 5%">
                                <div class="sorted-column">
                                    <span>Видимость</span>
                                    <a @if($data['sort_active']['active']) class="active" @endif href="{{ $data['sort_active']['href'] }}">
                                        <i class="fa fa-{{ $data['sort_active']['icon'] }}"></i>
                                    </a>
                                </div>
                            </th>
                            <th style="width: 5%">
                                <div class="sorted-column">
                                    <span>Просмотры</span>
                                    <a @if($data['sort_views']['active']) class="active" @endif href="{{ $data['sort_views']['href'] }}">
                                        <i class="fa fa-{{ $data['sort_views']['icon'] }}"></i>
                                    </a>
                                </div>
                            </th>
                            <th style="width: 15%">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['posts'] as $post)

                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>
                                    @if($post->mainImage)
                                        <div class="post-list-image">
                                            <img src="{{ Storage::url($post->mainImage->path_origin) }}">
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category->title }}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input onchange="tootlePostActive({{ $post->id }})" type="checkbox" @if($post->active) checked @endif name="switch-active-{{ $post->id }}" class="custom-control-input" id="active-switch-{{ $post->id }}">
                                        <label class="custom-control-label" for="active-switch-{{ $post->id }}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($post->views < 10)
                                        <span class="badge bg-danger">
                                    @elseif ($post->views < 100)
                                        <span class="badge bg-warning">
                                    @elseif ($post->views > 100)
                                        <span class="badge bg-success">
                                    @endif
                                        {{ $post->views }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-button-block">
                                        <a href="{{ route('admin.post.show', $post->id) }}" class="btn bg-gradient-success"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.post.edit', $post->id) }}" class="btn bg-gradient-primary"><i class="fas fa-pen"></i></a>
                                        <form action="{{ route('admin.post.delete', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn bg-gradient-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
{{--                 {{ dd(request()->query()) }}--}}
{{--                 {{dd($data['posts']->appends(array_merge(request()->query(), ['sort' => 'asc']))->url(1))}}--}}
                 {{ $data['posts']->appends(request()->query())->links('admin.include.pagination') }}
            </div>
            @else
                <div>
                    Тут пока нет ни одного поста
                </div>
            @endif
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
