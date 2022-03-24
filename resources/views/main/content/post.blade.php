@extends('main.layouts.main', ['data' => $data['layout']])

@section('content')
    @include('main.includes.breadcrums', ['breadcrumbs' => $data['breadcrumbs']])
    <!--================Blog Area =================-->
    <section class="blog_area single-post-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 posts-list">
                    <div class="single-post">
                        <div class="feature-img">
                            <img
                                class="img-fluid"
                                src="{{ Storage::url($data['post']->image_path) }}"
                                alt="{{ $data['post']->title }}"
                            >
                        </div>
                        <div class="blog_details">
                            <h2>
                                {{ $data['post']->title }}
                            </h2>
                            <ul class="blog-info-link mt-3 mb-4">
                                <li><a href="#"><i class="fa fa-calendar"></i> {{ $data['post']->format_date }}</a></li>
                                <li><a href="#"><i class="fa fa-eye"></i> {{ $data['post']->views }}</a></li>
                            </ul>
                            <div class="content">
                                {!! $data['post']->content !!}
                            </div>
                        </div>
                    </div>
                    <div class="navigation-top">
                        <div class="d-sm-flex justify-content-between text-center">
                            <p class="like-info"><span class="align-middle"><i class="fa fa-heart"></i></span> Lily and 4
                                people like this</p>
                            <div class="col-sm-4 text-center my-2 my-sm-0">
                                <!-- <p class="comment-count"><span class="align-middle"><i class="fa fa-comment"></i></span> 06 Comments</p> -->
                            </div>
                            <ul class="social-icons">
                                <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-behance"></i></a></li>
                            </ul>
                        </div>
                        <div class="navigation-area">
                            @if(isset($data['additional_posts']))
                                <div class="row">
                                    @if($data['additional_posts']['prev'])
                                        <div
                                            class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                                            <div class="thumb">
                                                <a href="{{ route('public.content.post', [$data['additional_posts']['prev']->category->slug, $data['additional_posts']['prev']->slug]) }}">
                                                    <img
                                                        class="img-fluid post-additional-block"
                                                        src="{{ Storage::url($data['additional_posts']['prev']->image_path) }}"
                                                        alt="{{ $data['additional_posts']['prev']->title }}"
                                                    >
                                                </a>
                                            </div>
                                            <div class="arrow">
                                                <a href="{{ route('public.content.post', [$data['additional_posts']['prev']->category->slug, $data['additional_posts']['prev']->slug]) }}">
                                                    <span class="lnr text-white ti-arrow-left"></span>
                                                </a>
                                            </div>
                                            <div class="detials">
                                                <p>Prev Post</p>
                                                <a href="{{ route('public.content.post', [$data['additional_posts']['prev']->category->slug, $data['additional_posts']['prev']->slug]) }}">
                                                    <h4>{{ $data['additional_posts']['prev']->title }}</h4>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    @if($data['additional_posts']['next'])
                                        <div
                                            class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                                            <div class="detials">
                                                <p>Next Post</p>
                                                <a href="{{ route('public.content.post', [$data['additional_posts']['next']->category->slug, $data['additional_posts']['next']->slug]) }}">
                                                    <h4>{{ $data['additional_posts']['next']->title }}</h4>
                                                </a>
                                            </div>
                                            <div class="arrow">
                                                <a href="{{ route('public.content.post', [$data['additional_posts']['next']->category->slug, $data['additional_posts']['next']->slug]) }}">
                                                    <span class="lnr text-white ti-arrow-right"></span>
                                                </a>
                                            </div>
                                            <div class="thumb post-additional-block">
                                                <a href="{{ route('public.content.post', [$data['additional_posts']['next']->category->slug, $data['additional_posts']['next']->slug]) }}">
                                                    <img
                                                        class="img-fluid"
                                                        src="{{ Storage::url($data['additional_posts']['next']->image_path) }}"
                                                        alt="{{ $data['additional_posts']['next']->title }}"
                                                    >
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
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
    <!--================ Blog Area end =================-->
@endsection
