@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="col-4 mb-3">
            <button type="button" class="btn bg-gradient-success"><i class="fa fa-plus"></i></button>
        </div>
        <div class="col-12">
            @if(count($data['tags']) > 0)
             <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Теги</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tags-block" id="main-tags-block">
                        @foreach($data['tags'] as $tag)
                            <div id="tag-item-{{ $tag->id }}" class="main-tags-page-item bg-primary">
                                <div class="tag-item__title">
                                    {{ $tag->title }}
                                </div>
                                <div class="tag-item__edit-block">
                                    <button type="button" onclick="openModalTagRename({{ $tag->id }})" class="tag-item__edit btn-left tag-btn bg-gradient-success">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" onclick="deleteTag({{ $tag->id }})" class="tag-item__delete btn-right tag-btn bg-gradient-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
                <div>
                    Тут пока нет ни одного тега
                </div>
            @endif
        </div>
    </div><!-- /.container-fluid -->
    @include('admin.include.tags_rename', ['ajax'  => $data['ajax']]);
</section>
<!-- /.content -->
@endsection
