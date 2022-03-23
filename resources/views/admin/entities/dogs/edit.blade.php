@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div>
                <a href="{{ route('admin.entity.dog.index') }}" class="btn btn-default">назад</a>
            </div>
            <form action="{{ route('admin.entity.dog.update', $data['dog']->id) }}" method="post">
                @csrf
                @method('PATCH')
                <input type="hidden" name="active" value="0">
                <input type="hidden" id="filemanage-ajax" value="{{ route('admin.filemanager.get') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" @if($data['dog']->active) checked @endif name="active" class="custom-control-input" id="active-switch">
                                    <label class="custom-control-label" for="active-switch">Видимость</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title" class="required">Имя</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $data['dog']->name }}">
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
                                                    @if($data['dog'])
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
                                                    @if(!$data['dog']->gender)
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
                                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $data['dog']->birthday }}">
                                @error('birthday')
                                <div class="text-danger">{{ $errors->first('birthday') }}</div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="father-select">Отец</label>
                                <select class="custom-select rounded-5" id="father-select" name="father">
                                    <option value=""></option>
                                    @foreach($data['dogs_male'] as $dog)
                                            @if(isset($data['dog']->father_id) && $data['dog']->father_id === $dog->id)
                                                <option selected value="{{ $dog->id }}">{{ $dog->name }}</option>
                                            @else
                                                <option value="{{ $dog->id }}">{{ $dog->name }}</option>
                                            @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="mather-select">Мать</label>
                                <select class="custom-select rounded-5" id="mather-select" name="mother">
                                    <option value=""></option>
                                    @foreach($data['dogs_female'] as $dog)
                                        @if(isset($data['dog']->mother_id) && $data['dog']->mother_id === $dog->id)
                                            <option selected value="{{ $dog->id }}">{{ $dog->name }}</option>
                                        @else
                                            <option value="{{ $dog->id }}">{{ $dog->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-content">Описание</label>
                                    <textarea id="summernote" name="text" id="input-content">
                                        {{ $data['dog']->text }}
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
                                        @if($data['dog']->image)
                                            <img src="{{ Storage::url($data['dog']->mainImage->path_origin) }}">
                                        @else
                                            <img src="{{ Storage::url('public/noimg.png') }}">
                                        @endif
                                        <input type="hidden" id="main_image" name="image" class="main_image-input" value="{{ $data['dog']->image }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-content">Достижения</label>
                                <div class="achievements-block" id="achievements-block" data-last="{{ $data['dog']->achievments->count() }}">
                                    @if($data['dog']->achievments->count())
                                        @foreach($data['dog']->achievments as $index => $achievment)
                                            <div class="col-12 achievements-item" id="achievements-item-{{ $achievment->id }}">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-warning"><i class="fa fa-trophy"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">{{ $achievment->name }}</span>
                                                        <span class="info-box-number">{{ $achievment->format_date }}</span>
                                                        <input class="achievements-id" type="hidden" name="achievements[{{ $index }}][id]" value="{{ $achievment->id }}">
                                                        <input class="achievements-date" type="hidden" name="achievements[{{ $index }}][date]" value="{{ $achievment->date_receiving }}">
                                                        <input class="achievements-name" type="hidden" name="achievements[{{ $index }}][name]" value="{{ $achievment->name }}">
                                                    </div>
                                                </div>
                                                <button type="button" onclick="deleteAchievements(event.currentTarget)" class="btn achievement-delete-button">
                                                    <i class="fas fa-trash-alt">
                                                    </i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
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
