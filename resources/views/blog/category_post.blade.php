@extends('layouts.landing')

@section('main')
    <!-- Start Breadcarumb area  -->
    <div class="breadcrumb-area breadcarumb-style-1 ptb--90 pb_sm--50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="tmp-section-title-border text-center">
                            <div class="pres-line-separator-wrapper text-center mb--10">
                                <div class="line-separator line-left"></div>
                                <span class="subtitle">
                                <span class="number"><a href="/">01</a></span>
                                    <span class="subtitle-text">News Update</span>
                                    </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h1 class="title w-700 tmp-title-split">Our Latest Posts</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcarumb area  -->


    <!-- Start Blog List View  -->
    <div class="main-content">
        <div class="tmp-blog-area tmp-section-gapBottom">
            <div class="container">
                <div class="row mt_dec--30">
                    <div class="col-lg-12">
                        <div class="row row--15 g-5">
                            @foreach($posts as $post)
                                <div class="col-lg-6">
                                    <div class="tmp-card box-card-style-default card-list-view tmponhover">
                                        <div class="inner">
                                            <div class="thumbnail">
                                                <a class="image" href="{{ route('blog.show', $post->id) }}">
                                                    <img src="{{ asset($post->image) }}" alt="Blog Image">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h4 class="title"><a href="{{ route('blog.show', $post->id) }}">{{ $post->title }}</a></h4>
                                                <p class="descriptiion">{{ Str::limit($post->short_desc, 50) }}</p>
                                                <div class="read-more-btn">
                                                    <a class="btn-read-more" href="{{ route('blog.show', $post->id) }}"><span>Read More</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    {{--                    <div class="col-lg-12">--}}
                    {{--                        <div class="tmp-load-more d-flex justify-content-center mt--60">--}}
                    {{--                            <a class="tmp-btn btn-large round hover-icon-reverse" href="#">--}}
                    {{--                                    <span class="icon-reverse-wrapper">--}}
                    {{--                                        <span class="btn-text">View More Post</span>--}}
                    {{--                                    <span class="btn-icon"><i class="feather-loader"></i></span>--}}
                    {{--                                    <span class="btn-icon"><i class="feather-loader"></i></span>--}}
                    {{--                                    </span>--}}
                    {{--                            </a>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog List View  -->
@endsection
