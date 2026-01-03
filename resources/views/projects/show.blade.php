@extends('layouts.landing')

@section('main')
 <!-- Start Portfolio Details area  -->
        <div class="tmp-portfolio-details tmp-section-gapTop mb--40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="tmp-portfolio-details">
                            <div class="tmp-section-title-border text-center">
                                <div class="pres-line-separator-wrapper text-center mb--10">
                                    <div class="line-separator line-left"></div>
                                    <span class="subtitle">
                                        <span class="number"><a href="/">01</a></span>
                                    <span class="subtitle-text">Project Details</span>
                                    </span>
                                    <div class="line-separator line-right"></div>
                                </div>
                                <h2 class="title w-700 mb--30 tmp-title-split">{{ $project->title }}</span></h2>
                            </div>
                            <p class="text-center">{!! $project->short_desc !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Portfolio Details area  -->

        <div class="tmp-portfolio-details-bento-image-area tmp-section-gapBottom">
            <div class="container">
                <div class="row g-0">
                    <div class="col-lg-12">

                        <div class="slider-portfolio-area">
                            <div class="slider-animation-2 slider-activation-2 slider-dot tmp-slick-dot tmp-slick-arrow tmp-slick-arrow-white">
                                <div class="slider-area d-flex">

                                    <div class="thumbnail radious-6 large-image-portfolio-details">
                                        <img src="{{ asset($project->image) }}" alt="portfolio">
                                    </div>

                                </div>
                                @foreach($project->multiImage as $img)
                                    <div class="slider-area d-flex">

                                        <div class="thumbnail radious-6 large-image-portfolio-details">
                                            <img src="{{ asset($img->image) }}" alt="portfolio">
                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        </div>


                    </div>
                </div>
                <div class="row mt--60">
                    <div class="col-lg-8">
                        <div class="content-area">
                            <h2 class="title tmp-title-split">{{ $project->title }}</h2>
                            <p class="desc mb--20">{!! $project->long_desc !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-4">


                        <div class="left-sidebar sticky-top top-120">
                            <div class="single-wrapper-details-right-p bg-card tmponhover">
                                <h4>About My Project</h4>
                                <ul>
                                    <li>Client : <span>{{ $project->client }}</span></li>
                                    <li>Category : <span>{{ $project->project_category->name }}</span></li>
                                    <li>Date : <span>{{ $project->year }}</span></li>
                                    <li>Area : <span>{{ $project->location }}</span></li>
                                    <li>Website : <span>Rivertown Junction, Montana</span></li>
                                </ul>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!-- tmp case studies area start -->
        <div class="tmp-case-studies tmp-section-gapBottom">
            <div class="container">
                <div class="row mb--40">
                    <div class="col-lg-12">
                        <div class="tmp-section-title-border text-center">
                            <div class="pres-line-separator-wrapper text-center mb--10">
                                <div class="line-separator line-left"></div>
                                <span class="subtitle">
                                    <span class="number">04</span>
                                <span class="subtitle-text">Case Studies</span>
                                </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 tmp-title-split">Related Case Studies.</h2>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    @foreach($latest as $key => $pro)
                        <div class="col-lg-6 col-md-6 col-sm-12" data-sal="slide-up" data-sal-duration="00" data-sal-delay="{{ $key > 0 ? (200 + ($key * 100)) : 200 }}">
                            <div class="single-project-area-bottom-content">
                                <a href="{{ route('all-projects.show', $pro->id) }}" class="thumbnail invers-anime">
                                    <img src="{{ asset($pro->image) }}" alt="project">
                                </a>
                                <div class="inner">
                                    <a href="{{ route('all-projects.show', $pro->id) }}">
                                        <h4 class="title">{{ $pro->title }}</h4>
                                    </a>
                                    <p class="disc">
                                        {!! $pro->short_desc !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- tmp case studies area end -->
@endsection
