@extends('main.layouts.main', ['data' => $data['layout']])

@section('content')
    @include('main.includes.breadcrums')
    <!--================Blog Area =================-->
    <section class="blog_area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="blog_left_sidebar">
                        @if($data['posts']->count() > 0)
                            @include('main.content.elenents.post', ['posts' => $data['posts']])
                        @else
                            Тут пусто
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        @if($data['categories']->count() > 0)
                            @include('main.includes.categories', ['categories' => $data['categories']])
                        @endif
                        @if($data['top_posts']->count() > 0)
                            @include('main.includes.top-post', ['top_posts' => $data['top_posts']])
                        @endif
                        @if($data['tags']->count() > 0)
                            @include('main.includes.tags', ['tags' => $data['tags']])
                        @endif
                        @if($data['last_gallary']->count() > 0)
                            @include('main.includes.gallary', ['gallary' => $data['last_gallary']])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Blog Area =================-->
@endsection
