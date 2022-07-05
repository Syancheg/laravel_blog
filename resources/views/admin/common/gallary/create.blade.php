@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ url()->previous() }}" class="btn btn-default">назад</a>
            </div>
            <form action="{{ route('admin.gallary.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="active" value="0">
                <input type="hidden" id="filemanage-ajax" value="{{ route('admin.filemanager.get') }}">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title" class="required">Заголовок</label>
                        <input value="{{old('name')}}" type="text" class="form-control" id="title" name="name" placeholder="Заголовок">
                        @error('name')
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gallary-main-image">Главное изображение</label>
                        <div class="post-main-image" id="gallary-main-image" data-count="1" data-type="image">
                            <div class="hover-image-block" data-type="gallary-main-image" data-id="0">
                                @if(old('image'))
                                    <img src="{{ Storage::url(old('image_src')) }}">
                                @else
                                    <img src="{{ Storage::url('public/noimg.png') }}">
                                @endif
                                <input type="hidden" id="main_image" name="image" class="main_image-input" value="{{ old('image') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="gallary-images-section">
                        <label for="gallary-images">Галерея изображений</label>
                        <div class="gallary-images-block" id="gallary-images" data-count="50" data-type="image">
                            @if(old('images'))
                                @foreach(old('images') as $image)
                                    <div class="gallary-block gallary" data-type="gallary-images" data-id="{{ $image['id'] }}">
                                        <img class="image" src="{{ Storage::url($image['path']) }}">
                                        <input type="hidden" id="gallary-image-{{ $image['id'] }}" name="images[]" class="gallary-input" value="{{ $image['id'] }}">
                                        <div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="gallary-checkbox-image-{{ $image['id'] }}" value="{{ $image['id'] }}">
                                                <label for="gallary-checkbox-image-{{ $image['id'] }}" class="custom-control-label">Выбрать</label>
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
