@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ url()->previous() }}" class="btn btn-default">назад</a>
            </div>
            @foreach($errors as $error)
                {{ $error }}
            @endforeach
            <form action="{{ route('admin.gallary.update', $data['gallary']->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="active" value="0">
                <input type="hidden" id="filemanage-ajax" value="{{ route('admin.filemanager.get') }}">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title" class="required">Заголовок</label>
                        <input value="{{ $data['gallary']->name }}" type="text" class="form-control" id="title" name="name" placeholder="Заголовок">
                        @error('name')
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gallary-main-image">Главное изображение</label>
                        <div class="post-main-image" id="gallary-main-image" data-count="1" data-type="image">
                            <div
                                class="hover-image-block"
                                data-type="gallary-main-image"
                                @if($data['gallary']->image)
                                data-id="{{ $data['gallary']->image }}"
                                @else
                                data-id="0"
                                @endif
                            >
                                @if($data['gallary']->image)
                                    <img src="{{ Storage::url($data['gallary']->mainImage->path_origin) }}">
                                @else
                                    <img src="{{ Storage::url('public/noimg.png') }}">
                                @endif
                                    <input
                                        type="hidden"
                                        id="main_image"
                                        name="image"
                                        class="main_image-input"
                                        @if($data['gallary']->image)
                                        value="{{ $data['gallary']->image }}"
                                        @else
                                        value="0"
                                        @endif
                                    >
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="gallary-images-section">
                        <label for="gallary-images">Галерея изображений</label>
                        <div class="gallary-images-block" id="gallary-images" data-count="50" data-type="image">
                            @if($data['gallary']->images)
                                @foreach($data['gallary']->images as $index => $image)
                                    <div class="gallary-block gallary" data-type="gallary-images" data-id="{{ $image->imageSource->id }}">
                                        <img class="image" src="{{ Storage::url($image->imageSource->path_origin) }}">
                                        <input type="hidden" id="gallary-image-{{ $image->imageSource->id }}" name="images[]" class="gallary-input" value="{{ $image->imageSource->id }}">
                                        <div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="gallary-checkbox-image-{{ $image->imageSource->id }}" value="{{ $image->imageSource->id }}">
                                                <label for="gallary-checkbox-image-{{ $image->imageSource->id }}" class="custom-control-label">Выбрать</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="gallary-add-button">
                                <button type="button" onclick="openFilemanager('gallary-images')" class="btn bg-gradient-primary">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" onclick="deleteGallaryItem()" class="btn bg-gradient-danger">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        @error('images')
                        <div class="text-danger">{{ $errors->first('images') }}</div>
                        @enderror
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
