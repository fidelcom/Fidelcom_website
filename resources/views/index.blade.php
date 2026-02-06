@extends('layouts.landing')

@section('main')


        <!-- Start Slider Area -->
        <div class="slider-area banner-two-shape-control tmp-slider-style-1 with-bg-tin bg-transparent height-850 position-relative" style="z-index: 1;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="inner text-center">
                            <div class="tmp-section-title-border text-center">
                                <div class="pres-line-separator-wrapper text-center mb--10">
                                    <div class="line-separator line-left"></div>
                                    <span class="subtitle tmp-title-split">
                                        <span class="number">01</span>
                                    <span class="subtitle-text">DIGITAL CONSULTING AGENCY</span>
                                    </span>
                                    <div class="line-separator line-right"></div>
                                </div>
                            </div>
                            <h1 class="title display-two w-700 mt--20 mb--20 tmp-title-split"><span>Fidelcom Systems</span> <br>
                                <span class="header-caption">
                                    <span class="cd-headline clip is-full-width">
                                        <span class="cd-words-wrapper">
                                            @foreach($services as $key => $service)
                                                <b class="{{ $key === 0 ? 'is-visible' : 'is-hidden' }} theme-gradient">{{ $service->title }}.</b>
                                            @endforeach

{{--                                            <b class="is-hidden theme-gradient">Mobile Apps.</b>--}}
{{--                                            <b class="is-hidden theme-gradient">Graphics Design.</b>--}}
{{--                                            <b class="is-hidden theme-gradient">UI/UX Designs.</b>--}}
{{--                                            <b class="is-hidden theme-gradient">Branding.</b>--}}
{{--                                            <b class="is-hidden theme-gradient">IT.</b>--}}
{{--                                            <b class="is-hidden theme-gradient">Consulting.</b>--}}
{{--                                            <b class="is-hidden theme-gradient">Agency.</b>--}}
                                        </span>
                                </span>
                                </span>
                            </h1>
                            <p class="description b1 tmp-title-split-p">{!! $sliders->first()->description !!}</p>
                            <div class="button-group">
                                <a class="tmp-btn round hover-icon-reverse" href="#">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Request Quote</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>

                                <a class="tmp-btn btn-border round hover-icon-reverse" href="{{ route('contact.us') }}">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Contact Us</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner-svg"></div>
            <div class="banner-svg banner-svg-right"></div>
            <!-- <div class="slider-bg-dot-shape">
                <div class="wrapper blocksync-scroll-trigger blocksync-stars-area fade_in animation-order-16">
                    <div class="blocksync-stars"></div>
                    <div class="blocksync-stars2"></div>
                    <div class="blocksync-stars3"></div>
                </div>
            </div> -->
            <!-- <div class="slider-bg-dot-shape two-splash">
                <div class="wrapper blocksync-scroll-trigger blocksync-stars-area fade_in animation-order-16">
                    <div class="blocksync-stars"></div>
                    <div class="blocksync-stars2"></div>
                    <div class="blocksync-stars3"></div>
                </div>
            </div> -->
            <div class="shape-left-top">
                <img src="{{ asset('assets/images/banner/shape-it-1.svg') }}" alt="">
            </div>
            <div class="shape-right-bottom">
                <img src="{{ asset('assets/images/banner/shape-it-1.svg') }}" alt="">
            </div>
        </div>
        <!-- End Slider Area  -->

        <!-- Start About Area  -->
        <div class="about-area about-style-4 tmp-section-gap">
            <div class="container">
                <div class="row row--5 align-items-center">
                    <div class="col-lg-7 pr--40 pr_sm--0">
                        <div class="about-2-thumbnail-left-wrapper">
                            <div class="single-thumbnail invers-anime">
                                <img loading="lazy" src="{{ asset($about->image) }}" alt="about">

                            </div>
                            <div class="single-thumbnail invers-anime mt--80">
                                <img loading="lazy" src="{{ asset($about->image) }}" alt="about">
{{--                                <div class="video-icon">--}}
{{--                                    <a class="tmp-btn rounded-player popup-video" href="{{ asset('assets/images/video/01.mp4') }}">--}}
{{--                                        <span><i class="feather-play"></i></span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
                            </div>
{{--                            <div class="absolute-rating-area images-left-right-float image">--}}
{{--                                <div class="stars-area">--}}
{{--                                    <img loading="lazy" src="assets/images/icons/stars.svg" alt="small-image">--}}
{{--                                    <img loading="lazy" src="assets/images/icons/stars.svg" alt="small-image">--}}
{{--                                    <img loading="lazy" src="assets/images/icons/stars.svg" alt="small-image">--}}
{{--                                    <img loading="lazy" src="assets/images/icons/stars.svg" alt="small-image">--}}
{{--                                    <img loading="lazy" src="assets/images/icons/stars.svg" alt="small-image">--}}
{{--                                    <span>(4.99+)</span>--}}
{{--                                </div>--}}
{{--                                <p><span class="odometer" data-count="599">00</span> Review form our <br> Best Clients</p>--}}
{{--                                <div class="profile-share justify-content-start">--}}
{{--                                    <a href="#" class="avatar" data-tooltip="Mark JOrdan" tabindex="0"><img src="assets/images/testimonial/tooltip-01.png" alt="education"></a>--}}
{{--                                    <a href="#" class="avatar" data-tooltip="Mark" tabindex="0"><img src="assets/images/testimonial/tooltip-02.png" alt="education"></a>--}}
{{--                                    <a href="#" class="avatar" data-tooltip="Jordan" tabindex="0"><img src="assets/images/testimonial/tooltip-03.png" alt="education"></a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <div class="col-lg-5 mt_md--40 mt_sm--40">
                        <div class="content">
                            <div class="inner">
                                <div class="tmp-section-title-border text-start hero__sub-title">
                                    <div class="pres-line-separator-wrapper mb--10">
                                        <span class="subtitle"><span class="number">01</span> <span class="subtitle-text">ABOUT BUSINESS</span></span>
                                        <div class="line-separator"></div>
                                    </div>
                                </div>

                                <h2 class="title w-700 tmp-title-split">{{ $about->title }}
                                </h2>
                                <ul class="feature-list">
                                    <li>
                                        <div class="icon">
                                            <i class="feather-check"></i>
                                        </div>
                                        <div class="title-wrapper">
                                            <h4 class="title">Company Overview</h4>
                                            <p class="text">{!! $about->description !!}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="feather-check"></i>
                                        </div>
                                        <div class="title-wrapper">
                                            <h4 class="title">Our Vision</h4>
                                            <p class="text">{!! $about->vision !!}</p>
                                        </div>
                                    </li>
                                </ul>
                                <div class="about-btn mt--30">
                                    <a class="tmp-btn round text-center" href="{{ route('about.home') }}">About Fidelcom</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End About Area  -->


        <!-- Start Service Area  -->
        <div class="tmp-service-area tmp-section-gapBottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tmp-section-title-border text-center">
                            <div class="pres-line-separator-wrapper text-center mb--10">
                                <div class="line-separator line-left"></div>
                                <span class="subtitle">
                                    <span class="number">03</span>
                                <span class="subtitle-text">What we can do for you</span>
                                </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 tmp-title-split">Our Latest Services</h2>
                            <p class="description b1 tmp-title-split-p">IT Solutions, Software Development & Digital Services in Nigeria and Beyond
                            </p>
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
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12" data-sal="slide-up" data-sal-duration="700" {{ ($key+1) % 4 == 0 ? '': 'data-sal-delay="100"' }}>
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
{{--                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12" data-sal="slide-up" data-sal-duration="700">--}}
{{--                        <div class="service service__style--1 bg-color-card radius text-start tmp-border-none tmponhover">--}}
{{--                            <div class="icon">--}}
{{--                                <img src="assets/images/services/icons/04.png" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="content">--}}
{{--                                <h4 class="title w-600">--}}
{{--                                    <a href="service-details.html">Design</a>--}}
{{--                                </h4>--}}
{{--                                <p class="description mb--0">There are many variations variations--}}
{{--                                    of passages of Lorem available.</p>--}}
{{--                                <div class="discover-btn mt--20">--}}
{{--                                    <a class="tmp-btn round btn-small btn-border hover-icon-reverse" href="service-details.html">--}}
{{--                                        <span class="icon-reverse-wrapper">--}}
{{--                        <span class="btn-text">Discover services</span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        </span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="shape-service-1">--}}
{{--                                <img src="assets/images/services/shape/01.png" alt="service">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}



{{--                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12" data-sal="slide-up" data-sal-duration="700" data-sal-delay="200">--}}
{{--                        <div class="service service__style--1 bg-color-card radius text-start tmp-border-none tmponhover">--}}
{{--                            <div class="icon">--}}
{{--                                <img src="assets/images/services/icons/03.png" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="content">--}}
{{--                                <h4 class="title w-600">--}}
{{--                                    <a href="service-details.html">Application</a>--}}
{{--                                </h4>--}}
{{--                                <p class="description mb--0">Variations There are many variations of passages of Lorem available.</p>--}}
{{--                                <div class="discover-btn mt--20">--}}
{{--                                    <a class="tmp-btn round btn-small btn-border hover-icon-reverse" href="service-details.html">--}}
{{--                                        <span class="icon-reverse-wrapper">--}}
{{--                        <span class="btn-text">Discover services</span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        </span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="shape-service-1">--}}
{{--                                <img src="assets/images/services/shape/01.png" alt="service">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12" data-sal="slide-up" data-sal-duration="700" data-sal-delay="200">--}}
{{--                        <div class="service service__style--1 bg-color-card radius text-start tmp-border-none tmponhover">--}}
{{--                            <div class="icon">--}}
{{--                                <img src="assets/images/services/icons/01.png" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="content">--}}
{{--                                <h4 class="title w-600">--}}
{{--                                    <a href="service-details.html">Support</a>--}}
{{--                                </h4>--}}
{{--                                <p class="description mb--0">Variations There are many variations--}}
{{--                                    of passages of Lorem available.</p>--}}
{{--                                <div class="discover-btn mt--20">--}}
{{--                                    <a class="tmp-btn round btn-small btn-border hover-icon-reverse" href="service-details.html">--}}
{{--                                        <span class="icon-reverse-wrapper">--}}
{{--                        <span class="btn-text">Discover services</span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        </span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="shape-service-1">--}}
{{--                                <img src="assets/images/services/shape/01.png" alt="service">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12" data-sal="slide-up" data-sal-duration="700">--}}
{{--                        <div class="service service__style--1 bg-color-card radius text-start tmp-border-none tmponhover">--}}
{{--                            <div class="icon">--}}
{{--                                <img src="assets/images/services/icon-01.png" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="content">--}}
{{--                                <h4 class="title w-600">--}}
{{--                                    <a href="service-details.html">Office</a>--}}
{{--                                </h4>--}}
{{--                                <p class="description mb--0">Office are many variations variations--}}
{{--                                    of passages of Lorem available.</p>--}}
{{--                                <div class="discover-btn mt--20">--}}
{{--                                    <a class="tmp-btn round btn-small btn-border hover-icon-reverse" href="service-details.html">--}}
{{--                                        <span class="icon-reverse-wrapper">--}}
{{--                        <span class="btn-text">Discover services</span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        </span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="shape-service-1">--}}
{{--                                <img src="assets/images/services/shape/01.png" alt="service">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">--}}
{{--                        <div class="service service__style--1 bg-color-card radius text-start tmp-border-none tmponhover">--}}
{{--                            <div class="icon">--}}
{{--                                <img src="assets/images/services/icon-02.png" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="content">--}}
{{--                                <h4 class="title w-600">--}}
{{--                                    <a href="service-details.html">Web Award</a>--}}
{{--                                </h4>--}}
{{--                                <p class="description mb--0">Web App there are many variations--}}
{{--                                    variations of of Lorem available.</p>--}}
{{--                                <div class="discover-btn mt--20">--}}
{{--                                    <a class="tmp-btn round btn-small btn-border hover-icon-reverse" href="service-details.html">--}}
{{--                                        <span class="icon-reverse-wrapper">--}}
{{--                        <span class="btn-text">Discover services</span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        </span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="shape-service-1">--}}
{{--                                <img src="assets/images/services/shape/01.png" alt="service">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12" data-sal="slide-up" data-sal-duration="700" data-sal-delay="200">--}}
{{--                        <div class="service service__style--1 bg-color-card radius text-start tmp-border-none tmponhover">--}}
{{--                            <div class="icon">--}}
{{--                                <img src="assets/images/services/icons/06.png" alt="service">--}}
{{--                            </div>--}}
{{--                            <div class="content">--}}
{{--                                <h4 class="title w-600">--}}
{{--                                    <a href="service-details.html">Call Center</a>--}}
{{--                                </h4>--}}
{{--                                <p class="description mb--0">Call Center are many variations of passages passages of Lorem of Lorem available.</p>--}}
{{--                                <div class="discover-btn mt--20">--}}
{{--                                    <a class="tmp-btn round btn-small btn-border hover-icon-reverse" href="service-details.html">--}}
{{--                                        <span class="icon-reverse-wrapper">--}}
{{--                        <span class="btn-text">Discover services</span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        </span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="shape-service-1">--}}
{{--                                <img src="assets/images/services/shape/01.png" alt="service">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12" data-sal="slide-up" data-sal-duration="700" data-sal-delay="200">--}}
{{--                        <div class="service service__style--1 bg-color-card radius text-start tmp-border-none tmponhover">--}}
{{--                            <div class="icon">--}}
{{--                                <img src="assets/images/services/icons/05.png" alt="service">--}}
{{--                            </div>--}}
{{--                            <div class="content">--}}
{{--                                <h4 class="title w-600">--}}
{{--                                    <a href="service-details.html">Managemenet</a>--}}
{{--                                </h4>--}}
{{--                                <p class="description mb--0">Managemenet are many variations--}}
{{--                                    of passages of Lorem available.</p>--}}
{{--                                <div class="discover-btn mt--20">--}}
{{--                                    <a class="tmp-btn round btn-small btn-border hover-icon-reverse" href="service-details.html">--}}
{{--                                        <span class="icon-reverse-wrapper">--}}
{{--                        <span class="btn-text">Discover services</span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                        </span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="shape-service-1">--}}
{{--                                <img src="assets/images/services/shape/01.png" alt="service">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
        <!-- End Service Area  -->


        <!-- tmp business case area start -->
        <div class="tmp-business-case tmp-section-gapBottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tmp-section-title-border text-center">
                            <div class="pres-line-separator-wrapper text-center mb--10">
                                <div class="line-separator line-left"></div>
                                <span class="subtitle">
                                    <span class="number">03</span>
                                <span class="subtitle-text">Our Projects</span>
                                </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 tmp-title-split">Specialist Portfolio Cases</h2>
                            <p class="description b1 tmp-title-split-p">There are many variations of passages of Lorem Ipsum
                                available,
                                <br>but the majority have suffered alteration.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row g-5 mt--10 tmp_jump_animation-wrapper">
                    @foreach($projects->take(4) as $project)
                        <div class="col-lg-6 col-md-6 col-sm-12 tmp-jump__item">
                            <div class="single-project-style-three invers-anime">
                                <a href="{{ route('portfolio.show', $project->id) }}" class="thumbnail">
                                    <img loading="lazy" src="{{ asset($project->image) }}" alt="project">
                                </a>
                                <div class="inner-content tmponhover">
                                    <a href="{{ route('portfolio.show', $project->id) }}">
                                        <h4 class="title">{{ $project->title }}</h4>
                                    </a>
                                    <span>{{ $project->project_category->name }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- tmp business case area end -->

        <!-- our business service area start -->
        <div class="my-business-service-area tmp-section-gapBottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="title-flex-between">
                            <div class="tmp-section-title-border text-start">
                                <div class="pres-line-separator-wrapper text-start mb--10">
                                    <span class="subtitle">
                                        <span class="subtitle-text">Why Choose Fidelcom System Limited</span>
                                    </span>
                                    <div class="line-separator line-right"></div>
                                </div>
                                <h2 class="title w-700 tmp-title-split">Your Trusted IT & Digital Solutions Partner in Nigeria and Beyond</h2>
                            </div>
{{--                            <div class="tmp-load-more d-flex justify-content-center">--}}
{{--                                <a class="tmp-btn btn-large hover-icon-reverse" href="#">--}}
{{--                                    <span class="icon-reverse-wrapper">--}}
{{--                                        <span class="btn-text">View More Service</span>--}}
{{--                                    <span class="btn-icon"><i class="feather-loader"></i></span>--}}
{{--                                    <span class="btn-icon"><i class="feather-loader"></i></span>--}}
{{--                                    </span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
                        </div>


                    </div>
                </div>
                <div class="row g-5 mt--20">
                    <div class="col-lg-12">
                        @foreach($whyChooseUs as $key=>$us)
                            @if($key % 2 == 0)
                                <div class="single-service-list-area" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                                <div class="row g-5 align-items-center">
                                    <div class="col-lg-6">
                                        <a href="#" class="thumbnail-service-list invers-anime">
                                            <img src="{{ asset($us->image) }}" alt="Business consulting">
                                        </a>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="inner-content">
                                            <div class="head">
                                                <div class="icon">
                                                    <img src="{{ asset('assets/images/services/list/icon/01.svg') }}" alt="Business">
                                                </div>
                                                <h6 class="title">{{ $us->title }}</h6>
                                            </div>
                                            <p class="disc">
                                                {!! $us->desc !!}
                                            </p>
                                            <a class="tmp-btn hover-icon-reverse" href="~">
                                            <span class="icon-reverse-wrapper">
                                            <span class="btn-text">See Details</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                                <div class="single-service-list-area" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                                    <div class="row g-5 align-items-center">

                                        <div class="col-lg-6 order-2 order-lg-1 order-md-2 order-sm-2">
                                            <div class="inner-content">
                                                <div class="head">
                                                    <div class="icon">
                                                        <img src="{{ asset('assets/images/services/list/icon/02.svg') }}" alt="Business">
                                                    </div>
                                                    <h6 class="title">{{ $us->title }}</h6>
                                                </div>
                                                <p class="disc">
                                                    {!! $us->desc !!}
                                                </p>
                                                <a class="tmp-btn hover-icon-reverse" href="#">
                                            <span class="icon-reverse-wrapper">
                                            <span class="btn-text">See Details</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 order-1 order-lg-2 order-md-1 order-sm-1">
                                            <a href="#" class="thumbnail-service-list invers-anime">
                                                <img src="{{ asset($us->image) }}" alt="Business consulting">
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            @endif

                        @endforeach


{{--                        <div class="single-service-list-area" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">--}}
{{--                            <div class="row g-5 align-items-center">--}}
{{--                                <div class="col-lg-6">--}}
{{--                                    <a href="service-details.html" class="thumbnail-service-list invers-anime">--}}
{{--                                        <img src="assets/images/services/list/03.webp" alt="Business consulting">--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-6">--}}
{{--                                    <div class="inner-content">--}}
{{--                                        <div class="head">--}}
{{--                                            <div class="icon">--}}
{{--                                                <img src="assets/images/services/list/icon/03.svg" alt="Business">--}}
{{--                                            </div>--}}
{{--                                            <h6 class="title">Financial Idea</h6>--}}
{{--                                        </div>--}}
{{--                                        <p class="disc">--}}
{{--                                            Our Financial Idea service helps companies expand faster with strategic planning, marketing solutions, and expert guidance to achieve sustainable success.--}}
{{--                                        </p>--}}
{{--                                        <a class="tmp-btn hover-icon-reverse" href="service-details.html">--}}
{{--                                            <span class="icon-reverse-wrapper">--}}
{{--                                            <span class="btn-text">See Details</span>--}}
{{--                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                            </span>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="single-service-list-area" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">--}}
{{--                            <div class="row g-5 align-items-center">--}}

{{--                                <div class="col-lg-6 order-2 order-lg-1 order-md-2 order-sm-2">--}}
{{--                                    <div class="inner-content">--}}
{{--                                        <div class="head">--}}
{{--                                            <div class="icon">--}}
{{--                                                <img src="assets/images/services/list/icon/04.svg" alt="Business">--}}
{{--                                            </div>--}}
{{--                                            <h6 class="title">Minimal Achievement</h6>--}}
{{--                                        </div>--}}
{{--                                        <p class="disc">--}}
{{--                                            Our minimal achievement strategy focuses on steady growth, smart resource use, and sustainable progress to reach goals with efficiency.--}}
{{--                                        </p>--}}
{{--                                        <a class="tmp-btn hover-icon-reverse" href="service-details.html">--}}
{{--                                            <span class="icon-reverse-wrapper">--}}
{{--                                            <span class="btn-text">See Details</span>--}}
{{--                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>--}}
{{--                                            </span>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-6 order-1 order-lg-2 order-md-1 order-sm-1">--}}
{{--                                    <a href="service-details.html" class="thumbnail-service-list invers-anime">--}}
{{--                                        <img src="assets/images/services/list/04.webp" alt="Business consulting">--}}
{{--                                    </a>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
        </div>
        <!-- our business service area end -->


        <!-- Start Call To Action  -->
        <div class="tmp-callto-action-area with-shape position-relative">
            <div class="wrapper">
                <div class="tmp-callto-action clltoaction-style-default style-5">
                    <div class="container">
                        <div class="row row--0 align-items-center content-wrapper theme-shape">
                            <div class="col-lg-12">
                                <div class="inner">
                                    <div class="content text-center">
                                        <h2 class="title tmp-title-split">Ready to start creating <br> the perfect website and mobile app?</h2>
                                        <h6 class="subtitle tmp-title-split">A Mobile App, Web Design & IT Consulting That Delivers More</h6>
                                        <div class="call-to-btn d-flex justify-content-center">
                                            <a class="tmp-btn btn-extra-large hover-icon-reverse" href="{{ route('contact.us') }}">
                                                <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Contact Fidelcom</span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="tmp-profile-box mt--50">
                                        <div class="profile-share justify-content-center">
                                            <a href="#" class="avatar" data-tooltip="Mark JOrdan" tabindex="0"><img src="assets/images/testimonial/tooltip-01.png" alt="education"></a>
                                            <a href="#" class="avatar" data-tooltip="Mark" tabindex="0"><img src="assets/images/testimonial/tooltip-02.png" alt="education"></a>
                                            <a href="#" class="avatar" data-tooltip="Jordan" tabindex="0"><img src="assets/images/testimonial/tooltip-03.png" alt="education"></a>
                                            <div class="more-author-text">
                                                <h5 class="total-join-students">Join Over 200+ Clients</h5>
{{--                                                <p class="subtitle">--}}
{{--                                                    <a class="btn-read-more" target="_blank" href="https://themeforest.net/item/corpox-business-consulting-bootstrap-5-html-template/59767866"><span>Purchase Corpox</span></a>--}}
{{--                                                </p>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="shape-image wow move-out">
                        <img src="assets/images/shape/01.png" alt="call-to-action">
                    </div> -->
                            <div class="person-stand images-left-right-float">
                                <img loading="lazy" src="assets/images/call-to-action/01.png" alt="call-to-action">
                            </div>
                            <div class="bg-shape-area-cta-main tmponhover">
                                <img loading="lazy" src="assets/images/shape/01.webp" alt="">
                            </div>
                            <div class="bg-line-animatoin-area-global"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Call To Action  -->


        <!-- tmp video section start -->
        <div class="tmp-video-section-start-one tmp-section-gapTop">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="large-video-playing grow-thumbnail-1">
                            <video autoplay="" muted="" loop="" playsinline="" preload="metadata">
                                <source src="assets/images/video/02.mp4" type="video/mp4">
                            </video>
                            <div class="grow-thumbnail-1-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- tmp video section end -->

        <!-- Start FAQ Area  -->
        <div class="tmp-faq-area tmp-section-gap">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="thumbnail" data-sal="slide-right" data-sal-duration="800">
                            <img class="w-100 radius" loading="lazy" src="{{ asset('assets/images/about/about-4.png') }}" alt="About Images">
                        </div>
                    </div>
                    @php
                        $headings = ["headingOne", "headingTwo","headingThree","headingFour","headingFive",];
                        $collapses = ["collapseOne", "collapseTwo", "collapseThree", "collapseFour", "collapseFive"];
                    @endphp
                    <div class="col-lg-6">
                        <div class="tmp-accordion-style accordion" data-sal="slide-up" data-sal-duration="800">
                            <div class="accordion" id="accordionExamplea">
                                @foreach($faqs as $key=>$faq)
                                    <div class="accordion-item card tmponhover">
                                        <h2 class="accordion-header card-header" id="{{ $headings[$key] }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapses[$key] }}" {{ $key == 0 ? 'aria-expanded="true"' : 'aria-expanded="false"' }}  aria-controls="{{ $collapses[$key] }}">
                                                {{ $faq->question }}
                                            </button>
                                        </h2>
                                        <div id="{{ $collapses[$key] }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="{{ $headings[$key] }}" data-bs-parent="#accordionExamplea">
                                            <div class="accordion-body card-body">
                                                {!! $faq->answer !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


{{--                                <div class="accordion-item card tmponhover">--}}
{{--                                    <h2 class="accordion-header card-header" id="headingTwo">--}}
{{--                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">--}}
{{--                                            How does the consultation process work?--}}
{{--                                        </button>--}}
{{--                                    </h2>--}}
{{--                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExamplea">--}}
{{--                                        <div class="accordion-body card-body">--}}
{{--                                            After purchasing the product, if you need any support, you can share your issue with us by sending a mail to themespark11@gmail.com.--}}
{{--                                            Our support team will review your request and get back to you as soon as possible.--}}
{{--                                            We are always ready to assist you with installation.--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="accordion-item card tmponhover">--}}
{{--                                    <h2 class="accordion-header card-header" id="headingThree">--}}
{{--                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">--}}
{{--                                            How can I schedule a meeting?--}}
{{--                                        </button>--}}
{{--                                    </h2>--}}
{{--                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExamplea">--}}
{{--                                        <div class="accordion-body card-body">--}}
{{--                                            Yes, We will get update the Trydo. And you can get it any time. Next--}}
{{--                                            time we will comes with more feature.--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="accordion-item card tmponhover">--}}
{{--                                    <h2 class="accordion-header card-header" id="headingFour">--}}
{{--                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">--}}
{{--                                            Do you offer customized business solutions?--}}
{{--                                        </button>--}}
{{--                                    </h2>--}}
{{--                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExamplea">--}}
{{--                                        <div class="accordion-body card-body">--}}
{{--                                            You can run Corpox easily. First You'll need to have node and npm on your--}}
{{--                                            machine. So Please open your command prompt then check your node -v and--}}
{{--                                            npm -v Version.--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End FAQ Area  -->

        <!-- Start Testimonial Area  -->
        <div class="tmp-testimonial-area tmp-section-gapBottom mb--30 mb_sm--60">
            <div class="container">
                <div class="row mb--20">
                    <div class="col-lg-12">
                        <div class="tmp-section-title-border text-center" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                            <div class="pres-line-separator-wrapper text-center mb--10">
                                <div class="line-separator line-left"></div>
                                <span class="subtitle">
                                    <span class="number">03</span>
                                <span class="subtitle-text">Client Feedback</span>
                                </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 tmp-title-split">Our Client Feedback</h2>
                            <p class="description b1 tmp-title-split-p">There are many variations of passages of Lorem Ipsum
                                available,
                                <br>but the majority have suffered alteration.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row tmp-slick-dot tmp-slick-arrow testimonial-activation mt--30" data-sal="slide-up" data-sal-duration="800">
                    @foreach($testimonials as $testimonial)
                        <div class="col-lg-12">
                            <!-- Start single Testimonial -->
                            <div class="testimonial-style-two" tabindex="-1" style="width: 100%; display: inline-block;">
                                <div class="row align-items-center row--20">
                                    <div class="col-lg-5 col-md-4">
                                        <div class="thumbnail tmponhover"><img class="w-100" src="{{ asset($testimonial->image) }}" alt="Corporate Template"></div>
                                    </div>
                                    <div class="col-lg-7 col-md-8">
                                        <div class="content mt_sm--40"><span class="form">{{ $testimonial->location }}</span>
                                            <p class="description">
                                                {!! $testimonial->desc !!}
                                            </p>
                                            <div class="client-info">
                                                <h4 class="title">{{ $testimonial->name }}</h4>
                                                <h6 class="subtitle">App Developer</h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- End single Testimonial -->
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
        <!-- End Testimonial Area  -->

        <!-- tmp Pricing area start -->
{{--        <div class="tmp-pricing-area tmp-section-gapBottom">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-lg-12">--}}
{{--                        <div class="tmp-section-title-border text-center">--}}
{{--                            <div class="pres-line-separator-wrapper text-center mb--10">--}}
{{--                                <div class="line-separator line-left"></div>--}}
{{--                                <span class="subtitle">--}}
{{--                                    <span class="number">03</span>--}}
{{--                                <span class="subtitle-text">Our Pricing</span>--}}
{{--                                </span>--}}
{{--                                <div class="line-separator line-right"></div>--}}
{{--                            </div>--}}
{{--                            <h2 class="title w-700 tmp-title-split">Our Yearly & Monthly Pricing</h2>--}}
{{--                            <p class="description b1 tmp-title-split-p">Easily schedule your appointment with just a few clicks. Our team is <br> always ready to assist you at your preferred time.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row mt--20">--}}
{{--                    <div class="col-lg-12">--}}
{{--                        <ul class="nav nav-tabs pricing-tab-nav-yearly" id="myTab" role="tablist">--}}
{{--                            <li class="nav-item" role="presentation">--}}
{{--                                <button class="nav-link tmp-btn btn-border active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Monthly Plan</button>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item" role="presentation">--}}
{{--                                <button class="nav-link tmp-btn btn-border" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Yearly Plan</button>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                        <div class="tab-content pricing-table-items mt--40" id="myTabContent">--}}
{{--                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">--}}
{{--                                <div class="row g-5">--}}
{{--                                    <div class="col-lg-4 col-md-6 col-sm-12">--}}
{{--                                        <div class="pricing-table large-padding tmponhover" style="--x: 473.5px; --y: 112.109375px;">--}}
{{--                                            <div class="pricing-table-header">--}}
{{--                                                <div class="top d-flex justify-content-between align-items-start">--}}
{{--                                                    <h4>basic</h4>--}}

{{--                                                </div>--}}
{{--                                                <h1>$59 <span>/ Month</span></h1>--}}
{{--                                            </div>--}}
{{--                                            <ul class="feature-lists">--}}
{{--                                                <li>Need your wireframe</li>--}}
{{--                                                <li>Design with Figma, Framer</li>--}}
{{--                                                <li>Implement with Webflow, React, WordPress, Laravel/PHP</li>--}}
{{--                                                <li>Remote/Online</li>--}}
{{--                                                <li>Work in business days, no weekend.</li>--}}
{{--                                                <li>Support 6 months</li>--}}
{{--                                            </ul>--}}
{{--                                            <a href="#" class="tmp-btn btn-primary btn-border w-100">Pick This Package</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-4 col-md-6 col-sm-12">--}}
{{--                                        <div class="pricing-table large-padding tmponhover" style="--x: 473.5px; --y: 112.109375px;">--}}
{{--                                            <div class="pricing-table-header">--}}
{{--                                                <div class="top d-flex justify-content-between align-items-start">--}}
{{--                                                    <h4>Standard</h4>--}}

{{--                                                </div>--}}
{{--                                                <h1>$159 <span>/ Month</span></h1>--}}
{{--                                            </div>--}}
{{--                                            <ul class="feature-lists">--}}
{{--                                                <li>Need your wireframe</li>--}}
{{--                                                <li>Design with Figma, Framer</li>--}}
{{--                                                <li>Implement with Webflow, React, WordPress, Laravel/PHP</li>--}}
{{--                                                <li>Remote/Online</li>--}}
{{--                                                <li>Work in business days, no weekend.</li>--}}
{{--                                                <li>Support 6 months</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="popular-tag">Popular</div>--}}
{{--                                            <a href="#" class="tmp-btn btn-primary w-100">Pick This Package</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-4 col-md-6 col-sm-12">--}}
{{--                                        <div class="pricing-table large-padding tmponhover" style="--x: 473.5px; --y: 112.109375px;">--}}
{{--                                            <div class="pricing-table-header">--}}
{{--                                                <div class="top d-flex justify-content-between align-items-start">--}}
{{--                                                    <h4>Premium</h4>--}}

{{--                                                </div>--}}
{{--                                                <h1>$259 <span>/ Month</span></h1>--}}
{{--                                            </div>--}}
{{--                                            <ul class="feature-lists">--}}
{{--                                                <li>Need your wireframe</li>--}}
{{--                                                <li>Design with Figma, Framer</li>--}}
{{--                                                <li>Implement with Webflow, React, WordPress, Laravel/PHP</li>--}}
{{--                                                <li>Remote/Online</li>--}}
{{--                                                <li>Work in business days, no weekend.</li>--}}
{{--                                                <li>Support 6 months</li>--}}
{{--                                            </ul>--}}
{{--                                            <a href="#" class="tmp-btn btn-border btn-primary w-100">Pick This Package</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">--}}
{{--                                <div class="row g-5">--}}
{{--                                    <div class="col-lg-4 col-md-6 col-sm-12">--}}
{{--                                        <div class="pricing-table large-padding tmponhover" style="--x: 473.5px; --y: 112.109375px;">--}}
{{--                                            <div class="pricing-table-header">--}}
{{--                                                <div class="top d-flex justify-content-between align-items-start">--}}
{{--                                                    <h4>basic</h4>--}}

{{--                                                </div>--}}
{{--                                                <h1>$159 <span>/ Year</span></h1>--}}
{{--                                            </div>--}}
{{--                                            <ul class="feature-lists">--}}
{{--                                                <li>Need your wireframe</li>--}}
{{--                                                <li>Design with Figma, Framer</li>--}}
{{--                                                <li>Implement with Webflow, React, WordPress, Laravel/PHP</li>--}}
{{--                                                <li>Remote/Online</li>--}}
{{--                                                <li>Work in business days, no weekend.</li>--}}
{{--                                                <li>Support 6 months</li>--}}
{{--                                            </ul>--}}
{{--                                            <a href="#" class="tmp-btn btn-border btn-primary w-100">Pick This Package</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-4 col-md-6 col-sm-12">--}}
{{--                                        <div class="pricing-table large-padding tmponhover" style="--x: 473.5px; --y: 112.109375px;">--}}
{{--                                            <div class="pricing-table-header">--}}
{{--                                                <div class="top d-flex justify-content-between align-items-start">--}}
{{--                                                    <h4>Standard</h4>--}}

{{--                                                </div>--}}
{{--                                                <h1>$259 <span>/ Year</span></h1>--}}
{{--                                            </div>--}}
{{--                                            <ul class="feature-lists">--}}
{{--                                                <li>Need your wireframe</li>--}}
{{--                                                <li>Design with Figma, Framer</li>--}}
{{--                                                <li>Implement with Webflow, React, WordPress, Laravel/PHP</li>--}}
{{--                                                <li>Remote/Online</li>--}}
{{--                                                <li>Work in business days, no weekend.</li>--}}
{{--                                                <li>Support 6 months</li>--}}
{{--                                            </ul>--}}
{{--                                            <div class="popular-tag">Popular</div>--}}
{{--                                            <a href="#" class="tmp-btn btn-primary w-100">Pick This Package</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-4 col-md-6 col-sm-12">--}}
{{--                                        <div class="pricing-table large-padding tmponhover" style="--x: 473.5px; --y: 112.109375px;">--}}
{{--                                            <div class="pricing-table-header">--}}
{{--                                                <div class="top d-flex justify-content-between align-items-start">--}}
{{--                                                    <h4>Premium</h4>--}}

{{--                                                </div>--}}
{{--                                                <h1>$759 <span>/ Year</span></h1>--}}
{{--                                            </div>--}}
{{--                                            <ul class="feature-lists">--}}
{{--                                                <li>Need your wireframe</li>--}}
{{--                                                <li>Design with Figma, Framer</li>--}}
{{--                                                <li>Implement with Webflow, React, WordPress, Laravel/PHP</li>--}}
{{--                                                <li>Remote/Online</li>--}}
{{--                                                <li>Work in business days, no weekend.</li>--}}
{{--                                                <li>Support 6 months</li>--}}
{{--                                            </ul>--}}
{{--                                            <a href="#" class="tmp-btn  btn-border btn-primary w-100">Pick This Package</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- tmp Pricing area start -->



        <!-- appoinment area start -->
        <div class="inv-appoinment-area-start tmp-section-gapBottom" id="contactus">
            <div class="container">
                <div class="row mb--20">
                    <div class="col-lg-12">
                        <div class="tmp-section-title-border text-center" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                            <div class="pres-line-separator-wrapper text-center mb--10">
                                <div class="line-separator line-left"></div>
                                <span class="subtitle">
                                <span class="number">03</span>
                                <span class="subtitle-text">Appointment</span>
                                </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 tmp-title-split">Book An Appointment</h2>
                            <p class="description b1 tmp-title-split-p">Easily schedule your appointment with just a few clicks. Our team is <br> always ready to assist you at your preferred time.</p>
                        </div>
                    </div>
                </div>
                <div class="row g-5">

                    <div class="col-lg-5 mt_md--30 mt_sm--30">
                        <div class="aapoiment-left-area-thumbnail">
                            <img src="{{ asset('assets/images/appoinment/01.webp') }}" alt="appoinment">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form class="contact-form-1 appoinment-form-wrapper tmponhover tmp-dynamic-form" id="contact-form" method="POST" action="{{ route('contact.us.store') }}">
                            @csrf
                            <div class="form-group-wrapper">
                                <div class="form-group tmponhover">
                                    <input type="text" name="name" id="contact-name" placeholder="Your Name" required>
                                </div>
                                <div class="form-group tmponhover">
                                    <input type="tel" name="phone" id="contact-phone" placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="form-group tmponhover">
                                <input type="email" id="contact-email" name="email" placeholder="Your Email" required>
                            </div>

                            <div class="form-group tmponhover">
                                <input type="text" id="subject" name="subject" placeholder="Your Subject">
                            </div>

                            <div class="form-group tmponhover">
                                <textarea name="message" id="contact-message" placeholder="Your Message"></textarea>
                            </div>

                            <div class="form-group tmponhover">
                                <button name="submit" type="submit" id="submit" class="btn-default btn-large tmp-btn" style="width: 100%;">
                                    <span>Submit Now</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- appoinment area end -->


        <!-- Start Blog Area  -->
        <div class="blog-area tmp-section-gapBottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tmp-section-title-border text-center">
                            <div class="pres-line-separator-wrapper text-center mb--10">
                                <div class="line-separator line-left"></div>
                                <span class="subtitle">
                                    <span class="number">03</span>
                                <span class="subtitle-text">Latests News</span>
                                </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 tmp-title-split">Our Latests News</h2>
                            <p class="description b1 tmp-title-split-p">There are many variations of passages of Lorem Ipsum
                                available,
                                <br>but the majority have suffered alteration.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row g-5 mt--10">
                    @foreach($posts as $key => $post)
                        @if($key % 2 == 0)
                            <div class="col-lg-4 col-md-6 col-12" data-sal="slide-up" data-sal-duration="700" {{ $key > 0 ? 'data-sal-delay="'.($key * 100).'"' : '' }}>>
                                <div class="tmp-card box-card-style-default tmponhover">
                                    <div class="inner">
                                        <div class="thumbnail invers-anime">
                                            <a class="image" href="{{ route('blog.show', $post->id) }}">
                                                <img loading="lazy" class="w-100" src="{{ asset($post->image) }}" alt="Blog Image">
                                            </a>

                                            <span class="tag-news">{{ $post->blog_category->name }}</span>
                                        </div>
                                        <div class="content">
                                            <ul class="inversweb-meta-list">
                                                <li>
                                                    <span><i class="feather-user"></i></span>
                                                    <a href="{{ route('blog.show', $post->id) }}">{{ $post->author }}</a>
                                                </li>
                                                <li class="separator">-</li>
                                                <li>{{ $post->created_at->format('d M Y') }}</li>

                                                <li class="comment-area">
                                                    <i class="feather-message-circle"></i>
                                                    <span>{{ $post->comment->count() }}</span>
                                                </li>
                                            </ul>
                                            <h4 class="title"><a href="{{ route('blog.show', $post->id) }}">{{ $post->title }}</a></h4>
                                            <p class="descriptiion">{!! Str::limit($post->short_desc, 70) !!}</p>
                                            <div class="read-more-btn">
                                                <a class="tmp-btn btn-border" href="{{ route('blog.show', $post->id) }}"><span>Read More</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-4 col-md-6 col-12" data-sal="slide-up" data-sal-duration="700" {{ $key > 0 ? 'data-sal-delay="'.($key * 100).'"' : '' }}>>
                                <div class="tmp-card box-card-style-default tmponhover">
                                    <div class="inner">

                                        <div class="content">
                                            <ul class="inversweb-meta-list">
                                                <li>
                                                    <span><i class="feather-user"></i></span>
                                                    <a href="{{ route('blog.show', $post->id) }}">{{ $post->author }}</a>
                                                </li>
                                                <li class="separator">-</li>
                                                <li>{{ $post->created_at->format('d M Y') }}</li>

                                                <li class="comment-area">
                                                    <i class="feather-message-circle"></i>
                                                    <span>{{ $post->comment->count() }}</span>
                                                </li>
                                            </ul>
                                            <h4 class="title"><a href="{{ route('blog.show', $post->id) }}">{{ $post->title }}</a></h4>
                                            <p class="descriptiion">{!! Str::limit($post->short_desc, 70) !!}</p>
                                            <div class="read-more-btn">
                                                <a class="tmp-btn btn-border" href="{{ route('blog.show', $post->id) }}"><span>Read More</span></a>
                                            </div>
                                        </div>
                                        <div class="thumbnail invers-anime">
                                            <a class="image" href="{{ route('blog.show', $post->id) }}"><img loading="lazy" class="w-100" src="{{ asset($post->image) }}" alt="Blog Image"></a>
                                            <span class="tag-news">{{ $post->blog_category->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
        <!-- End Blog Area  -->


@endsection
