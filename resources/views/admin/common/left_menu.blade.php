@extends('admin.layouts.main', ['data' => $data['layout']])

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-4 mb-3">
                <button type="button" id="refresh_left_menu" class="btn bg-gradient-success"><i class="fa fa-refresh"></i></button>
            </div>
            <div class="col-12">
                @if(count($data['paths']) > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Категории</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th style="width: 60%">Наименование</th>
                                    <th style="width: 5%">Префикс</th>
                                    <th style="width: 15%">Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['paths'] as $path)
                                    <tr>
                                        <td>{{ $path->id }}</td>
                                        <td>{{ $path->title }}</td>
                                        <td>{{ $path->path_prefix }}</td>
                                        <td>
                                            <div class="action-button-block">
                                                <button class="btn bg-gradient-success"><i class="fa fa-check"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="#">«</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div>
                    </div>
                @else
                    <div>
                        Тут пока нет ни одного пути
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
