@extends('layouts.landing')

@section('main')
    <!-- Start Elements Area  -->
    <div class="tmp-service-details-area tmp-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-service-details">
                        <div class="tmp-section-title-border text-center">
                            <div class="pres-line-separator-wrapper text-center mb--10">
                                <div class="line-separator line-left"></div>
                                <span class="subtitle">
                                        <span class="number"><a href="/">01</a></span>
                                    <span class="subtitle-text">Service Details</span>
                                    </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 mb--30 tmp-title-split">{{ $service->title }}</h2>
                        </div>
                        <div class="thumbnail thumbnail-large-details mt--80 mt_sm--10 jarallax" data-black-overlay="1">
                            <img class="radius-10 w-100 jarallax-img" src="{{ asset($service->image) }}" alt="Service Details">
                        </div>



                        <div class="row justify-content-center mt--50">
                            <div class="col-lg-8">
                                <h2 class="title">{{ $service->title }}</h2>
                                <p class="discription mt--30">
                                    {!! $service->long_desc !!}                                </p>


                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Elements Area  -->

    <!-- Srart About Area  -->
    <div class="about-area about-style-4 tmp-section-gapBottom">
        <div class="container">
            <div class="row row--40 g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="content">
                        <div class="inner">
                            <h3 class="title w-700 mb--20">Let’s Talk</h3>
                            <p class="b1">The full service we are offering is specifically designed to meet your
                                business needs and projects.</p>

                            <p>The full service we are offering is specifically designed to meet your
                                business needs and projects.The full service we are offering is specifically designed to meet your
                                business needs and projects.</p>

                            <div class="read-more-btn">
                                <a class="tmp-btn icon-hover" href="{{ route('contact.us') }}">
                                    <span class="btn-text">Contact With us</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt_md--40 mt_sm--40">
                    <div class="video-btn">
                        <div class="video-popup icon-center">
                            <div class="overlay-content">
                                <div class="thumbnail"><img class="radius-small" src="{{ asset('assets/images/about/about-3.webp') }}" alt="Corporate Image"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About Area  -->

    <!-- Start Service__Style--1 Area  -->
    <div class="tmp-service-area tmp-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                    <span class="number">04</span>
                                <span class="subtitle-text">Services</span>
                                </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h2 class="title w-700">Related More Service.</h2>
                    </div>
                </div>
            </div>
            @php
                $icons = [
                    "assets/images/services/icons/04.png",
                    "assets/images/services/icons/02.png",
                    "assets/images/services/icons/03.png",
                    "assets/images/services/icons/01.png",
                    "assets/images/services/icon-01.png",
                    "assets/images/services/icon-02.png",
                    "assets/images/services/icons/06.png",
                    "assets/images/services/icons/05.png"
                    ];
            @endphp
            <div class="row g-5 service-wrapper mt--10">
                @foreach($services as $key => $service)
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12" data-sal="slide-up" data-sal-duration="700" {{ $key > 0 ? 'data-sal-delay="'.($key * 100) .'"': '' }}>
                        <div class="service service__style--1 bg-color-card radius text-start tmp-border-none tmponhover">
                            <div class="icon">
                                <img src="{{ asset($icons[$key]) }}" alt="">
                            </div>
                            <div class="content">
                                <h4 class="title w-600">
                                    <a href="{{ route('all-services.show', $service->id) }}">{{ $service->title }}</a>
                                </h4>
                                <p class="description mb--0">{{ $service->short_desc }}</p>
                                <div class="discover-btn mt--20">
                                    <a class="tmp-btn round btn-small btn-border hover-icon-reverse" href="{{ route('all-services.show', $service->id) }}">
                                        <span class="icon-reverse-wrapper">
                        <span class="btn-text">Discover services</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="shape-service-1">
                                <img src="{{ asset('assets/images/services/shape/01.png') }}" alt="service">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Service__Style--1 Area  -->

    <!-- cta modern style -->
    <div class="cta-main-wrapper bg-cta-modern bg_image jarallax" data-speed=".8" data-black-overlay="5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="call-to-action-modern-wrapper">
                        <h2 class="title">
                            Let's discuss your <br>
                            <span class="header-caption">
                                    <span class="cd-headline zoom">
                                        <span class="cd-words-wrapper">
                                            <b class="is-visible theme-gradient">Consulting.</b>
                                            <b class="is-hidden theme-gradient">Business.</b>
                                            <b class="is-hidden theme-gradient">Innovation.</b>
                                        </span>
                                </span>
                                </span>
                        </h2>
                        <div class="right-wrapper">
                            <div class="icons">
                                <img src="{{ asset('assets/images/call-to-action/icons/01.svg') }}" alt="icons">
                            </div>
                            <p>
                                Looking for Collaboration? <br> <a href="#">{{  $contact->email }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cta modern style end -->
@endsection
