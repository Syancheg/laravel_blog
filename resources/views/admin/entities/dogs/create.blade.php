@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div>
            <a href="{{ route('admin.entity.dog.index') }}" class="btn btn-default">назад</a>
        </div>
        <form action="{{ route('admin.entity.dog.store') }}" method="post">
            @csrf
            <input type="hidden" name="active" value="0">
            <input type="hidden" id="filemanage-ajax" value="{{ route('admin.filemanager.get') }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="title" class="required">Имя</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                            @error('name')
                            <div class="text-danger">{{ $errors->first('name') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input
                                                    name="gender"
                                                    type="radio"
                                                    @if(old('gender') && old('gender') === 1)
                                                        checked
                                                    @endif
                                                    value="1">
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" value="Мужской">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input
                                                    name="gender"
                                                    type="radio"
                                                    @if(old('gender') && old('gender') === 0)
                                                    checked
                                                    @endif
                                                    value="0">
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" value="Женский">
                                    </div>
                                </div>
                            </div>
                            @error('gender')
                            <div class="text-danger">{{ $errors->first('gender') }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="birthday" class="required">День рождения</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                            @error('birthday')
                            <div class="text-danger">{{ $errors->first('birthday') }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="father-select">Отец</label>
                            <select class="custom-select rounded-5" id="father-select" name="father">
                                <option value=""></option>
                                @foreach($data['dogs_male'] as $dog)
                                    <option value="{{ $dog->id }}">{{ $dog->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mather-select">Мать</label>
                            <select class="custom-select rounded-5" id="mather-select" name="mother">
                                <option value=""></option>
                                @foreach($data['dogs_female'] as $dog)
                                    <option value="{{ $dog->id }}">{{ $dog->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="input-content">Описание</label>
                                <textarea id="summernote" name="text" id="input-content">

                                    </textarea>
                                @error('content')
                                <div class="text-danger">{{ $errors->first('content') }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="dog_main_image">Фото</label>
                            <div class="post-main-image" id="dog_main_image" data-count="1">
                                <div class="hover-image-block" data-type="dog_main_image" data-id="0">
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
                            <label for="input-content">Достижения</label>
                            <div class="achievements-block" id="achievements-block" data-last="0">

                            </div>
                            <button type="button" data-toggle="modal" data-target="#modal-achievements" class="btn bg-gradient-success">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div><!-- /.container-fluid -->

    @include('admin.entities.dogs.add.achievements')
    @include('admin.include.filemanager')
    @include('admin.include.achievements')
</section>
<!-- /.content -->
@endsection
