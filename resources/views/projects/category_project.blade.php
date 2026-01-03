@extends('layouts.landing')

@section('main')
    <!-- Start Portfolio Area  -->
    <div class="tmp-portfolio-area tmp-section-gap masonary-wrapper-activation">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                    <span class="number">+6</span>
                                <span class="subtitle-text">Projects</span>
                                </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h2 class="title w-700 tmp-title-split">Our Latest Projects</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-portfolio-filter filter-button-default messonry-button text-center mb--30">
                        <button data-filter="*" class="is-checked"><span class="filter-text">All
                    Project</span></button>
                        @foreach($projectCategories as $cat)
                            <button data-filter=".cat--{{ $cat->id }}"><span class="filter-text">{{ $cat->name }}</span></button>
                        @endforeach

                    </div>
                    <div class="portfolio-items grid-metro3 mesonry-list">
                        <div class="resizer"></div>
                        <!-- Start Single Portfolio  -->
                        @foreach($projects as $project)
                            <div class="portfolio-3 cat--{{ $project->project_category->id }}">
                                <div class="tmp-card portfolio">
                                    <div class="inner">
                                        <div class="thumbnail">
                                            <figure class="card-image">
                                                <a href="{{ route('all-projects.show', $project->id) }}">
                                                    <img src="{{ asset($project->image) }}" alt="Portfolio-01">
                                                </a>
                                            </figure>
                                            <a class="tmp-overlay" href="{{ route('all-projects.show', $project->id) }}"></a>
                                        </div>
                                        <div class="content">
                                            <h5 class="title mb--20">
                                                <a href="{{ route('all-projects.show', $project->id) }}">{{ $project->title }}</a>
                                            </h5>
                                            <div class="tmp-badge-group">
                                                <a href="{{ route('all-projects.show', $project->id) }}" class="tmp-badge-2">{{ $project->project_category->name }}</a>
                                                {{--                                                <a href="#" class="tmp-badge-2">App</a>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Start Single Portfolio  -->

                    </div>
                </div>
            </div>
            <!-- Start Load More Button  -->
            {{--            <div class="row row--15">--}}
            {{--                <div class="col-lg-12">--}}
            {{--                    <div class="tmp-load-more d-flex justify-content-center mt--60">--}}
            {{--                        <a class="tmp-btn btn-large hover-icon-reverse" href="#">--}}
            {{--                                <span class="icon-reverse-wrapper">--}}
            {{--                                    <span class="btn-text">Load More</span>--}}
            {{--                                <span class="btn-icon"><i class="feather-loader"></i></span>--}}
            {{--                                <span class="btn-icon"><i class="feather-loader"></i></span>--}}
            {{--                                </span>--}}
            {{--                        </a>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <!-- End Load More Button  -->
        </div>
    </div>
    <!-- End Portfolio Area  -->
@endsection
