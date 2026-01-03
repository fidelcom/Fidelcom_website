@extends('layouts.landing')

@section('main')
    <!-- Start Advance Pricing Area  -->
    <div class="tmp-blog-details-area">
        <div class="post-page-banner tmp-section-gapTop">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="content text-center">
                            <div class="tmp-section-title-border text-center">
                                <div class="pres-line-separator-wrapper text-center mb--10">
                                    <div class="line-separator line-left"></div>
                                    <span class="subtitle">
                                            <span class="number">01</span>
                                        <span class="subtitle-text">Post Details</span>
                                        </span>
                                    <div class="line-separator line-right"></div>
                                </div>
                                <h2 class="title w-700 mt--20 tmp-title-split">{{ $post->title }} <br> <span class="theme-gradient">{{ $post->blog_category->name }}</span></h2>
                            </div>
                            <ul class="tmp-meta-list">
                                <li>
                                    <i class="feather-user"></i>
                                    <a href="#">{{ $post->author }}</a>
                                </li>
                                <li>
                                    <i class="feather-calendar"></i>
                                    {{ $post->created_at->format('d M Y') }}
                                </li>
                                <li>
                                    <i class="feather-message-circle"></i>
                                    {{ $post->comment->count() }} Comment
                                </li>
                            </ul>
                            <div class="thumbnail position-relative blog-details-thumbnail-large alignwide mt--60">
                                <img class="w-100 radius" src="{{ asset($post->image) }}" alt="Blog Images">
                                <figcaption class="mt--15">{{ $post->title }}</figcaption>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="blog-details-content pt--30 tmp-section-gapBottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="content">
                            <p>{!! $post->long_desc !!}</p>


                            <div class="comments-wrapper-main pt--40">
                                <div class="comments-area">
                                    <div class="trydo-blog-comment">
                                        <h5 class="comment-title mb--40">{{ $post->comment->count() }} replies on “{{ $post->title }}”</h5>
                                        <!-- Start Coment List  -->
                                        <ul class="comment-list">

                                            @foreach($post->comment as $comment)
                                                <!-- Start Single Comment  -->
                                                <li class="comment parent">
                                                    <div class="single-comment tmponhover">
                                                        <div class="comment-author comment-img">
                                                            <img class="comment-avatar" src="{{ $comment->image }}" alt="">
                                                            <div class="m-b-20">
                                                                <div class="commenter">{{ $comment->first_name.' '.$comment->last_name }}</div>
                                                                <div class="time-spent"> {{ $comment->created_at->format('d M Y') }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="comment-text">
                                                            <p>{!! $comment->message !!}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <!-- End Single Comment  -->
                                            @endforeach



                                        </ul>
                                        <!-- End Coment List  -->
                                    </div>
                                </div>
                            </div>

                            <!-- Start Contact Form Area  -->
                            <div class="tmp-comment-form pt--60">
                                <div class="inner">
                                    <div class="section-title">
                                        <span class="subtitle">Have a Comment?</span>
                                        <h3 class="title">Leave a Comment</h3>
                                    </div>
                                    <form class="mt--40" action="{{ route('comment.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <div class="row g-5">
                                            <div class="col-lg-4 col-md-12 col-12">
                                                <div class="prsfrom-group">
                                                    <input type="text" name="first_name" placeholder="FirstName">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-12">
                                                <div class="prsfrom-group">
                                                    <input type="text" name="last_name" placeholder="LastName">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="prsfrom-group">
                                                    <input type="email" name="email" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="prsfrom-group">
                                                    <input type="text" name="phone" placeholder="Phone No">
                                                </div>
                                            </div>
{{--                                            <div class="col-lg-4">--}}
{{--                                                <div class="prsfrom-group">--}}
{{--                                                    <input type="file" name="image" placeholder="Photo">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <div class="prsfrom-group"><textarea name="message" placeholder="Comment"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="blog-btn">
                                                    <button class="tmp-btn btn-gradient btn-large" type="submit" >SEND MESSAGE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End Contact Form Area  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Advance Pricing Area  -->

    <!-- Start Blog List View  -->
    <div class="tmp-blog-area tmp-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="title-flex-between">
                        <div class="tmp-section-title-border text-start">
                            <div class="pres-line-separator-wrapper text-start mb--10">
                                    <span class="subtitle">
                                        <span class="number">4</span>
                                    <span class="subtitle-text">Recent News</span>
                                    </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 tmp-title-split">Our Recent News</h2>
                        </div>
                        <div class="tmp-load-more d-flex justify-content-center">
                            <a class="tmp-btn btn-large hover-icon-reverse" href="{{ route('blog') }}">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">View More News</span>
                                    <span class="btn-icon"><i class="feather-loader"></i></span>
                                    <span class="btn-icon"><i class="feather-loader"></i></span>
                                    </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-5 mt--5">
                @foreach($latest as $blog) @endforeach
                <div class="col-lg-6">
                    <div class="tmp-card box-card-style-default card-list-view tmponhover">
                        <div class="inner">
                            <div class="thumbnail invers-anime">
                                <a class="image" href="{{ route('blog.show', $blog->id) }}">
                                    <img src="{{ asset($post->image) }}" alt="Blog Image">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="{{ route('blog.show', $blog->id) }}">{{ $blog->title }}</a></h4>
                                <p class="descriptiion">{{ Str::limit($blog->short_desc, 50) }}</p>
                                <div class="read-more-btn">
                                    <a class="btn-read-more" href="{{ route('blog.show', $blog->id) }}"><span>Read More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- End Blog List View  -->
@endsection
