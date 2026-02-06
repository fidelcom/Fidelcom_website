@extends('layouts.landing')

@section('main')
    <!-- Start Slider Area  -->
    <div class="about-banner-area pt--150 tmp-shape-position">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                    <span class="number">01</span>
                                <span class="subtitle-text">Our Company's About
                                        Details.</span>
                                </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h1 class="title w-700 mt--20">{{ $about->title }}</h1>
                        <p class="b1">We design and develop world-class websites and applications.</p>
                    </div>

                </div>
            </div>
            <div class="row mt--30">
                <div class="col-lg-12">
                    <div class="video-btn">
                        <div class="video-popup icon-center">
                            <div class="overlay-content">
                                <div class="thumbnail"><img class="radius-small" src="{{ asset($about->image) }}"
                                                            alt="Corporate Image"></div>
{{--                                <div class="video-icon">--}}
{{--                                    <a class="tmp-btn rounded-player popup-video"--}}
{{--                                       href="https://www.youtube.com/watch?v=4jnzf1yj48M">--}}
{{--                                        <span><i class="feather-play"></i></span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="video-lightbox-wrapper"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Slider Area  -->

    <!-- Srart About Area  -->
    <div class="about-area about-style-4 tmp-section-gapTop">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="thumbnail-about-8">
                        <div class="large-image  invers-anime">
                            <img src="{{ asset($about->image) }}" alt="" loading="lazy">
                        </div>
{{--                        <div class="small-iamge-area images-left-right-float">--}}
{{--                            <img src="assets/images/about/about-12.png" alt="" loading="lazy">--}}
{{--                            <div class="video-icon">--}}
{{--                                <a class="tmp-btn rounded-player popup-video"--}}
{{--                                   href="https://www.youtube.com/watch?v=4jnzf1yj48M">--}}
{{--                                    <span><i class="feather-play"></i></span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="col-lg-7 pl--60 pl_md--10 pl_sm--10 mt_md--30 mt_sm--30">
                    <div class="about-wrapper-8">
                        <div class="tmp-section-title-border text-start">
                            <div class="pres-line-separator-wrapper text-start mb--10">
                                    <span class="subtitle">
                            <span class="number">03</span>
                                    <span class="subtitle-text">About Us</span>
                                    </span>
                                <div class="line-separator line-right"></div>
                            </div>
                            <h2 class="title w-700 tmp-title-split">Lets Know <span class="theme-gradient">About</span>
                                Fidelcom <br> Systems Limited</h2>
                        </div>
                        <p class="discription">{{ $about->description }}</p>

                        <div class="tmp-section-title-border text-start">
                            <h2 class="title w-700 tmp-title-split">Our Mission</h2>
                        </div>
                        <p class="discription">{{ $about->mission }}</p>

                        <div class="tmp-section-title-border text-start">
                            <h2 class="title w-700 tmp-title-split">Our Vision</h2>
                        </div>
                        <p class="discription">{{ $about->vision }}</p>


                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Start Service__Style--1 Area  -->
    <div class="tmp-service-area tmp-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10 tmp-title-split">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                        <span class="number">04</span>
                                    <span class="subtitle-text">Services</span>
                                    </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h2 class="title w-700 tmp-title-split">Our Latest Service</h2>
                        <a href="{{ route('all-services.index') }}" class="tmp-btn btn-primary">Our Service</a>
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
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12" data-sal="slide-up"
                         data-sal-duration="700" {{ ($key+1) % 4 == 0 ? '': 'data-sal-delay="100"' }}>
                        <div
                            class="service service__style--1 bg-color-card radius text-start tmp-border-none tmponhover">
                            <div class="icon">
                                <img src="{{ asset($icons[$key]) }}" alt="">
                            </div>
                            <div class="content">
                                <h4 class="title w-600">
                                    <a href="{{ route('all-services.show', $service->id) }}">{{ $service->title }}</a>
                                </h4>
                                <p class="description mb--0">{{ $service->short_desc }}</p>
                                <div class="discover-btn mt--20">
                                    <a class="tmp-btn round btn-small btn-border hover-icon-reverse"
                                       href="{{ route('all-services.show', $service->id) }}">
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

    <!-- End About Area  -->

    <!-- Start Main Counter up-5 Area  -->
    <div class="tmp-counterup-area tmp-section-gapTop">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                    <span class="number">+200</span>
                                <span class="subtitle-text">Awesome Clients</span>
                                </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h2 class="title w-700">Our Impact on Businesses</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="row g-5 mt--0">
                        @foreach($successes as $key => $success)
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="signle-fun-facts-one tmponhover">
                                    <div class="icon">
                                        <img src="{{ asset('assets/images/fun-facts/0'.($key+1).'.svg') }}"
                                             alt="fun-facts">
                                    </div>
                                    <h2 class="title"><span class="odometer"
                                                            data-count="{{ $success->value }}">00</span>+
                                    </h2>
                                    <span class="bototm">{{ $success->title }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Counter up-5 Area  -->

    <section class="tmp-get-in-touch-area area-2 tmp-section-gapTop">
        <div class="container">
            <div class="section-inner">
                <div class="left-image">
                    <img src="{{ asset('assets/images/contact/get-bg.webp') }}" width="420" alt="">
                </div>
                <div class="content">
                    <div class="icon">
                        <a href="tel:{{ $contact->phone }}"><i class="feather-phone"></i></a>
                    </div>
                    <div class="text">
                        <h4 class="title">Have Any Questions? Call Us</h4>
                        <a href="tel:{{ $contact->phone }}" class="phone">{{ $contact->phone }}</a>
                        <p class="desc">As the world's largest producer of business service
                            agency, {{ env('app_name') }} stands at the
                            forefront of the Business sector.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Start Timeline-Style-Four  -->
    <div class="tmp-timeline-area tmp-section-gapTop">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                    <span class="number">+3</span>
                                <span class="subtitle-text">Working Process</span>
                                </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h2 class="title w-700 tmp-title-split">Our Working Process</h2>
                        <p class="b1">We make your spending stress-free for you to have the perfect control.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1 mt--10">
                    <div class="timeline-style-two bg-color-blackest">
                        <div class="row row--0">
                            @foreach($processes as $key => $process)
                                <div class="col-lg-3 col-md-3 tmp-timeline-single no-gradient">
                                    <div class="tmp-timeline">
                                        <h6 class="title" data-sal="slide-up" data-sal-duration="700"
                                            data-sal-delay="200">
                                            {{ $process->title }}</h6>
                                        <div class="progress-line">
                                            <div class="line-inner"></div>
                                        </div>
                                        <div class="progress-dot">
                                            <div class="dot-level">
                                                <div class="dot-inner"></div>
                                            </div>
                                        </div>
                                        <p class="description" data-sal="slide-up" data-sal-duration="700"
                                           data-sal-delay="300">{!! $process->desc !!} </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Timeline-Style-Four  -->

    <div class="tmp-video-area tmp-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-btn">
                        <div class="video-popup icon-center">
                            <div class="overlay-content">
                                <div class="thumbnail"><img class="radius-small" src="assets/images/about/about-3.jpg"
                                                            alt="Corporate Image"></div>
{{--                                <div class="video-icon">--}}
{{--                                    <a class="tmp-btn rounded-player popup-video"--}}
{{--                                       href="https://www.youtube.com/watch?v=4jnzf1yj48M">--}}
{{--                                        <span><i class="feather-play"></i></span>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="video-lightbox-wrapper"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Team-Style-Default Style-Three Area  -->
    <div class="tmp-team-area tmp-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                    <span class="number">4</span>
                                <span class="subtitle-text">Talents</span>
                                </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h2 class="title w-700">Some of Our Talents.</h2>
                    </div>
                </div>
            </div>
            <div class="row g-5 mt--5 justify-content-center">
                @foreach($teams as $team)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="team-wrapper5 tmponhover">
                            <div class="image-area">
                                <a href="team-details.html">
                                    <img src="{{ asset($team->image) }}" alt="">
                                </a>
                            </div>
                            <div class="content-area">
                                <div class="left">
                                    <h6 class="title"><a href="team-details.html">{{ $team->name }}</a></h6>
                                    <p class="designation">{{ $team->position }}</p>
                                </div>
                                <a href="#" class="share"><i class="feather-share-2"></i></a>
                            </div>
                            <div class="social-wrapper">
                                <ul>
                                    <li>
                                        <a href="{{ $team->facebook }}">
                                            <i class="feather-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $team->twitter }}">
                                            <i class="feather-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $team->linkedin }}">
                                            <i class="feather-linkedin"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- End Team-Style-Default Style-Three Area  -->

    <!-- Start Testimonial Area -->
    <section class="tmp-section-gapBottom position-relative overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                    <span class="number">+4</span>
                                <span class="subtitle-text">Testimonials</span>
                                </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h2 class="title w-700 tmp-title-splitt">Our customers success stories</h2>
                    </div>
                    <div class="tmp-section-title-border text-center" data-sal="slide-up" data-sal-duration="700"
                         data-sal-delay="100">
                        <p class="b2 d-flex flex-wrap tmp-col-gap-20 justify-content-center map-wrapper-subtitle">
                            <span>August, 2025</span>
                            <span class="tmp-separator-vertical tmp-bg-primary-500"></span>
                            <span class="d-flex align-items-center">
                                    <span
                                        class="tmp-counter tmp-count tmp-counter-gradient tmp-gradient-text-4 tmp-fw-semibold mr--5">
                                        <span class="odometer" data-count="20">00</span>
                                <span class="tmp-counter-suffix">k+</span>
                                </span>
                                Success People
                                </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Start Testimonial Map Area -->
            <div class="tmp-testimonial-map-wrapper">
                <div class="tmp-inner position-relative z-2">
                    <div class="tmp-testimonial-map-img ">
                        <img src="{{ asset('assets/images/testimonial/map.png') }}" alt="World Map">
                    </div>
                    @php
                        $positions = [
            [
                'vertical'   => 23,
                'horizontal' => 15,
                'portion'    => 'portion-md',
                'placement'  => 'placed-right',
            ],
            [
                'vertical'   => 45,
                'horizontal' => 30,
                'portion'    => 'portion-lg',
                'placement'  => 'placed-top',
            ],
            [
                'vertical'   => 10,
                'horizontal' => 40,
                'portion'    => 'portion-xm',
                'placement'  => 'placed-top',
            ],
            [
                'vertical'   => 70,
                'horizontal' => 54,
                'portion'    => '',
                'placement'  => 'placed-top',
            ],
            [
                'vertical'   => 30,
                'horizontal' => 73,
                'portion'    => 'portion-xl',
                'placement'  => 'placed-top',
            ],
            [
                'vertical'   => 82,
                'horizontal' => 87,
                'portion'    => 'portion-sm',
                'placement'  => 'placed-top',
            ],
            // Add more safe positions
        ['vertical' => 15, 'horizontal' => 60, 'portion' => 'portion-md', 'placement' => 'placed-top'],
        ['vertical' => 55, 'horizontal' => 10, 'portion' => 'portion-lg', 'placement' => 'placed-right'],
        ['vertical' => 75, 'horizontal' => 25, 'portion' => 'portion-sm', 'placement' => 'placed-top'],
        ['vertical' => 35, 'horizontal' => 85, 'portion' => 'portion-xl', 'placement' => 'placed-top'],
        ['vertical' => 60, 'horizontal' => 70, 'portion' => '', 'placement' => 'placed-top'],
        ['vertical' => 20, 'horizontal' => 35, 'portion' => 'portion-md', 'placement' => 'placed-top'],
        ];
                    @endphp

                    @foreach($testimonials as $index => $testimonial)
                        @php
                            // Generate random positions between 10% and 90% to avoid edges
                            $vertical   = rand(15, 90);
                            $horizontal = rand(15, 150);

                            // Optional: different portion sizes for variety
                            $sizes = ['', 'portion-sm', 'portion-md', 'portion-lg', 'portion-xl', 'portion-xm'];
                            $portionClass = $sizes[array_rand($sizes)];

                            // Optional: alternate placement (right or top)
                            $placements = ['placed-top', 'placed-right'];
                            $boxPlacement = $placements[array_rand($placements)];

                            // Get the position for this testimonial (cycle if more than 6)
                            $pos = $positions[$index % count($positions)];
                        @endphp

                            <!-- Start Single LookBook -->
                        <div class="tmp-lookbook-portion {{ $pos['portion'] }}"
                             data-tmp-position-vertical="{{ $pos['vertical'] }}"
                             data-tmp-position-horigental="{{ $pos['horizontal'] }}">

                            <div class="tmp-lookbook-thumb">
                                <img class="rounded-circle"
                                     src="{{ $testimonial->image ?? 'assets/images/avatar/default.webp' }}"
                                     alt="Testimonial">
                            </div>

                            <div class="tmp-lookbook-content-box-wrapper">
                                <button class="tmp-lookbook-close-btn"><i class="fas fa-times"></i></button>

                                <div class="tmp-lookbook-content-box {{ $pos['placement'] }}">
                                    <div class="tmp-message-shape"></div>
                                    <div class="tmp-inner">
                                        <p class="b2 tmp-text-heading mb--20">
                                            “{!! $testimonial->desc !!}”
                                        </p>
                                        <div class="tmp-separator tmp-bg-primary-opacity-400 mb--10"></div>
                                        <div class="b4 d-flex justify-content-between">
                        <span>
                            <span class="tmp-fw-medium tmp-text-heading">{{ $testimonial->name }}</span>
                            - {{ $testimonial->location }}
                        </span>
                                            <span class="tmp-fw-medium">
                            <span>
                                <!-- Star SVG -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 10 15"
                                     fill="none">
                                    <path
                                        d="M5.52447 1.15102C5.67415 0.690369 6.32585 0.69037 6.47553 1.15103L7.45934 4.17889C7.52628 4.3849 7.71826 4.52438 7.93487 4.52438H11.1186C11.6029 4.52438 11.8043 5.14419 11.4124 5.42889L8.83679 7.30021C8.66155 7.42753 8.58822 7.65322 8.65516 7.85923L9.63897 10.8871C9.78864 11.3477 9.2614 11.7308 8.86955 11.4461L6.29389 9.57479C6.11865 9.44747 5.88135 9.44747 5.70611 9.57479L3.13045 11.4461C2.73859 11.7308 2.21136 11.3477 2.36103 10.8871L3.34484 7.85923C3.41178 7.65322 3.33845 7.42753 3.16321 7.30021L0.587553 5.42889C0.195696 5.14419 0.397084 4.52438 0.881446 4.52438H4.06513C4.28174 4.52438 4.47372 4.3849 4.54066 4.17889L5.52447 1.15102Z"
                                        fill="#F7A51E"/>
                                </svg>
                            </span>
                            {{ $testimonial->rating ?? '4.9' }}
                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single LookBook -->
                    @endforeach

                    <!-- Start Single LookBook -->
                    {{--                    <div class="tmp-lookbook-portion portion-md" data-tmp-position-vertical="23"--}}
                    {{--                         data-tmp-position-horigental="15">--}}
                    {{--                        <div class="tmp-lookbook-thumb">--}}
                    {{--                            <img src="assets/images/avatar/avatar8.webp" alt="Thumbnail Image">--}}
                    {{--                        </div>--}}
                    {{--                        <div class="tmp-lookbook-content-box-wrapper">--}}
                    {{--                            <button class="tmp-lookbook-close-btn"><i class="fas fa-times"></i></button>--}}
                    {{--                            <div class="tmp-lookbook-content-box placed-right">--}}
                    {{--                                <div class="tmp-message-shape"></div>--}}
                    {{--                                <div class="tmp-inner">--}}
                    {{--                                    <p class="b2 tmp-text-heading mb--20">--}}
                    {{--                                        “Their team is always available to answer my questions. I trust them--}}
                    {{--                                        completely with my business insurance.”--}}
                    {{--                                    </p>--}}
                    {{--                                    <div class="tmp-separator tmp-bg-primary-opacity-400 mb--10"></div>--}}
                    {{--                                    <div class="b4 d-flex justify-content-between">--}}
                    {{--                                            <span>--}}
                    {{--                                                <span class="tmp-fw-medium tmp-text-heading">Lisa W.</span> - UI/UX--}}
                    {{--                                            Designer</span>--}}
                    {{--                                        <span class="tmp-fw-medium">--}}
                    {{--                                                <span>--}}
                    {{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
                    {{--                                                         viewBox="0 0 10 15" fill="none">--}}
                    {{--                                                        <path--}}
                    {{--                                                            d="M5.52447 1.15102C5.67415 0.690369 6.32585 0.69037 6.47553 1.15103L7.45934 4.17889C7.52628 4.3849 7.71826 4.52438 7.93487 4.52438H11.1186C11.6029 4.52438 11.8043 5.14419 11.4124 5.42889L8.83679 7.30021C8.66155 7.42753 8.58822 7.65322 8.65516 7.85923L9.63897 10.8871C9.78864 11.3477 9.2614 11.7308 8.86955 11.4461L6.29389 9.57479C6.11865 9.44747 5.88135 9.44747 5.70611 9.57479L3.13045 11.4461C2.73859 11.7308 2.21136 11.3477 2.36103 10.8871L3.34484 7.85923C3.41178 7.65322 3.33845 7.42753 3.16321 7.30021L0.587553 5.42889C0.195696 5.14419 0.397084 4.52438 0.881446 4.52438H4.06513C4.28174 4.52438 4.47372 4.3849 4.54066 4.17889L5.52447 1.15102Z"--}}
                    {{--                                                            fill="#F7A51E"/>--}}
                    {{--                                                    </svg>--}}
                    {{--                                                </span>--}}
                    {{--                                            4.9--}}
                    {{--                                            </span>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <!-- End Single LookBook -->--}}

                    {{--                    <!-- Start Single LookBook -->--}}
                    {{--                    <div class="tmp-lookbook-portion portion-lg" data-tmp-position-vertical="45"--}}
                    {{--                         data-tmp-position-horigental="30">--}}
                    {{--                        <div class="tmp-lookbook-thumb">--}}
                    {{--                            <img src="assets/images/avatar/avatar9.webp" alt="Thumbnail Image">--}}
                    {{--                        </div>--}}
                    {{--                        <div class="tmp-lookbook-content-box-wrapper">--}}
                    {{--                            <button class="tmp-lookbook-close-btn"><i class="fas fa-times"></i></button>--}}
                    {{--                            <div class="tmp-lookbook-content-box placed-top">--}}
                    {{--                                <div class="tmp-message-shape"></div>--}}
                    {{--                                <div class="tmp-inner">--}}
                    {{--                                    <p class="b2 tmp-text-heading mb--20">--}}
                    {{--                                        “Insurance Consulting made the process so simple. I finally feel secure with--}}
                    {{--                                        my home insurance!”--}}
                    {{--                                    </p>--}}
                    {{--                                    <div class="tmp-separator tmp-bg-primary-opacity-400 mb--10"></div>--}}
                    {{--                                    <div class="b4 d-flex justify-content-between">--}}
                    {{--                                            <span>--}}
                    {{--                                                <span class="tmp-fw-medium tmp-text-heading">Katherine</span> - UI/UX--}}
                    {{--                                            Designer</span>--}}
                    {{--                                        <span class="tmp-fw-medium">--}}
                    {{--                                                <span>--}}
                    {{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
                    {{--                                                         viewBox="0 0 10 15" fill="none">--}}
                    {{--                                                        <path--}}
                    {{--                                                            d="M5.52447 1.15102C5.67415 0.690369 6.32585 0.69037 6.47553 1.15103L7.45934 4.17889C7.52628 4.3849 7.71826 4.52438 7.93487 4.52438H11.1186C11.6029 4.52438 11.8043 5.14419 11.4124 5.42889L8.83679 7.30021C8.66155 7.42753 8.58822 7.65322 8.65516 7.85923L9.63897 10.8871C9.78864 11.3477 9.2614 11.7308 8.86955 11.4461L6.29389 9.57479C6.11865 9.44747 5.88135 9.44747 5.70611 9.57479L3.13045 11.4461C2.73859 11.7308 2.21136 11.3477 2.36103 10.8871L3.34484 7.85923C3.41178 7.65322 3.33845 7.42753 3.16321 7.30021L0.587553 5.42889C0.195696 5.14419 0.397084 4.52438 0.881446 4.52438H4.06513C4.28174 4.52438 4.47372 4.3849 4.54066 4.17889L5.52447 1.15102Z"--}}
                    {{--                                                            fill="#F7A51E"/>--}}
                    {{--                                                    </svg>--}}
                    {{--                                                </span>--}}
                    {{--                                            4.9--}}
                    {{--                                            </span>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <!-- End Single LookBook -->--}}

                    {{--                    <!-- Start Single LookBook -->--}}
                    {{--                    <div class="tmp-lookbook-portion portion-xm" data-tmp-position-vertical="10"--}}
                    {{--                         data-tmp-position-horigental="40">--}}
                    {{--                        <div class="tmp-lookbook-thumb">--}}
                    {{--                            <img src="assets/images/avatar/avatar10.webp" alt="Thumbnail Image">--}}
                    {{--                        </div>--}}
                    {{--                        <div class="tmp-lookbook-content-box-wrapper">--}}
                    {{--                            <button class="tmp-lookbook-close-btn"><i class="fas fa-times"></i></button>--}}
                    {{--                            <div class="tmp-lookbook-content-box placed-top">--}}
                    {{--                                <div class="tmp-message-shape"></div>--}}
                    {{--                                <div class="tmp-inner">--}}
                    {{--                                    <p class="b2 tmp-text-heading mb--20">--}}
                    {{--                                        “Their service is top-notch! I appreciate the personalized approach to my--}}
                    {{--                                        family's insurance needs.”--}}
                    {{--                                    </p>--}}
                    {{--                                    <div class="tmp-separator tmp-bg-primary-opacity-400 mb--10"></div>--}}
                    {{--                                    <div class="b4 d-flex justify-content-between">--}}
                    {{--                                            <span>--}}
                    {{--                                                <span class="tmp-fw-medium tmp-text-heading">Michael Burlie.</span> ---}}
                    {{--                                            UI/UX--}}
                    {{--                                            Designer</span>--}}
                    {{--                                        <span class="tmp-fw-medium">--}}
                    {{--                                                <span>--}}
                    {{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
                    {{--                                                         viewBox="0 0 10 15" fill="none">--}}
                    {{--                                                        <path--}}
                    {{--                                                            d="M5.52447 1.15102C5.67415 0.690369 6.32585 0.69037 6.47553 1.15103L7.45934 4.17889C7.52628 4.3849 7.71826 4.52438 7.93487 4.52438H11.1186C11.6029 4.52438 11.8043 5.14419 11.4124 5.42889L8.83679 7.30021C8.66155 7.42753 8.58822 7.65322 8.65516 7.85923L9.63897 10.8871C9.78864 11.3477 9.2614 11.7308 8.86955 11.4461L6.29389 9.57479C6.11865 9.44747 5.88135 9.44747 5.70611 9.57479L3.13045 11.4461C2.73859 11.7308 2.21136 11.3477 2.36103 10.8871L3.34484 7.85923C3.41178 7.65322 3.33845 7.42753 3.16321 7.30021L0.587553 5.42889C0.195696 5.14419 0.397084 4.52438 0.881446 4.52438H4.06513C4.28174 4.52438 4.47372 4.3849 4.54066 4.17889L5.52447 1.15102Z"--}}
                    {{--                                                            fill="#F7A51E"/>--}}
                    {{--                                                    </svg>--}}
                    {{--                                                </span>--}}
                    {{--                                            4.9--}}
                    {{--                                            </span>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <!-- End Single LookBook -->--}}

                    {{--                    <!-- Start Single LookBook -->--}}
                    {{--                    <div class="tmp-lookbook-portion" data-tmp-position-vertical="70" data-tmp-position-horigental="54">--}}
                    {{--                        <div class="tmp-lookbook-thumb">--}}
                    {{--                            <img src="assets/images/avatar/avatar11.webp" alt="Thumbnail Image">--}}
                    {{--                        </div>--}}
                    {{--                        <div class="tmp-lookbook-content-box-wrapper">--}}
                    {{--                            <button class="tmp-lookbook-close-btn"><i class="fas fa-times"></i></button>--}}
                    {{--                            <div class="tmp-lookbook-content-box placed-top">--}}
                    {{--                                <div class="tmp-message-shape"></div>--}}
                    {{--                                <div class="tmp-inner">--}}
                    {{--                                    <p class="b2 tmp-text-heading mb--20">--}}
                    {{--                                        “Thanks to their guidance, I found the perfect business insurance plan.--}}
                    {{--                                        Highly recommend!”--}}
                    {{--                                    </p>--}}
                    {{--                                    <div class="tmp-separator tmp-bg-primary-opacity-400 mb--10"></div>--}}
                    {{--                                    <div class="b4 d-flex justify-content-between">--}}
                    {{--                                            <span>--}}
                    {{--                                                <span class="tmp-fw-medium tmp-text-heading">Emily Rose</span> - UI/UX--}}
                    {{--                                            Designer</span>--}}
                    {{--                                        <span class="tmp-fw-medium">--}}
                    {{--                                                <span>--}}
                    {{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
                    {{--                                                         viewBox="0 0 10 15" fill="none">--}}
                    {{--                                                        <path--}}
                    {{--                                                            d="M5.52447 1.15102C5.67415 0.690369 6.32585 0.69037 6.47553 1.15103L7.45934 4.17889C7.52628 4.3849 7.71826 4.52438 7.93487 4.52438H11.1186C11.6029 4.52438 11.8043 5.14419 11.4124 5.42889L8.83679 7.30021C8.66155 7.42753 8.58822 7.65322 8.65516 7.85923L9.63897 10.8871C9.78864 11.3477 9.2614 11.7308 8.86955 11.4461L6.29389 9.57479C6.11865 9.44747 5.88135 9.44747 5.70611 9.57479L3.13045 11.4461C2.73859 11.7308 2.21136 11.3477 2.36103 10.8871L3.34484 7.85923C3.41178 7.65322 3.33845 7.42753 3.16321 7.30021L0.587553 5.42889C0.195696 5.14419 0.397084 4.52438 0.881446 4.52438H4.06513C4.28174 4.52438 4.47372 4.3849 4.54066 4.17889L5.52447 1.15102Z"--}}
                    {{--                                                            fill="#F7A51E"/>--}}
                    {{--                                                    </svg>--}}
                    {{--                                                </span>--}}
                    {{--                                            4.9--}}
                    {{--                                            </span>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <!-- End Single LookBook -->--}}

                    {{--                    <!-- Start Single LookBook -->--}}
                    {{--                    <div class="tmp-lookbook-portion portion-xl" data-tmp-position-vertical="30"--}}
                    {{--                         data-tmp-position-horigental="73">--}}
                    {{--                        <div class="tmp-lookbook-thumb">--}}
                    {{--                            <img src="assets/images/avatar/avatar12.webp" alt="Thumbnail Image">--}}
                    {{--                        </div>--}}
                    {{--                        <div class="tmp-lookbook-content-box-wrapper">--}}
                    {{--                            <button class="tmp-lookbook-close-btn"><i class="fas fa-times"></i></button>--}}
                    {{--                            <div class="tmp-lookbook-content-box placed-top">--}}
                    {{--                                <div class="tmp-message-shape"></div>--}}
                    {{--                                <div class="tmp-inner">--}}
                    {{--                                    <p class="b2 tmp-text-heading mb--20">--}}
                    {{--                                        “The team at Insurance Consulting transformed our coverage strategy. Their--}}
                    {{--                                        expertise was invaluable!”--}}
                    {{--                                    </p>--}}
                    {{--                                    <div class="tmp-separator tmp-bg-primary-opacity-400 mb--10"></div>--}}
                    {{--                                    <div class="b4 d-flex justify-content-between">--}}
                    {{--                                            <span>--}}
                    {{--                                                <span class="tmp-fw-medium tmp-text-heading">Sarah Tery.</span> - UI/UX--}}
                    {{--                                            Designer</span>--}}
                    {{--                                        <span class="tmp-fw-medium">--}}
                    {{--                                                <span>--}}
                    {{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
                    {{--                                                         viewBox="0 0 10 15" fill="none">--}}
                    {{--                                                        <path--}}
                    {{--                                                            d="M5.52447 1.15102C5.67415 0.690369 6.32585 0.69037 6.47553 1.15103L7.45934 4.17889C7.52628 4.3849 7.71826 4.52438 7.93487 4.52438H11.1186C11.6029 4.52438 11.8043 5.14419 11.4124 5.42889L8.83679 7.30021C8.66155 7.42753 8.58822 7.65322 8.65516 7.85923L9.63897 10.8871C9.78864 11.3477 9.2614 11.7308 8.86955 11.4461L6.29389 9.57479C6.11865 9.44747 5.88135 9.44747 5.70611 9.57479L3.13045 11.4461C2.73859 11.7308 2.21136 11.3477 2.36103 10.8871L3.34484 7.85923C3.41178 7.65322 3.33845 7.42753 3.16321 7.30021L0.587553 5.42889C0.195696 5.14419 0.397084 4.52438 0.881446 4.52438H4.06513C4.28174 4.52438 4.47372 4.3849 4.54066 4.17889L5.52447 1.15102Z"--}}
                    {{--                                                            fill="#F7A51E"/>--}}
                    {{--                                                    </svg>--}}
                    {{--                                                </span>--}}
                    {{--                                            4.9--}}
                    {{--                                            </span>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <!-- End Single LookBook -->--}}

                    {{--                    <!-- Start Single LookBook -->--}}
                    {{--                    <div class="tmp-lookbook-portion portion-sm" data-tmp-position-vertical="82"--}}
                    {{--                         data-tmp-position-horigental="87">--}}
                    {{--                        <div class="tmp-lookbook-thumb">--}}
                    {{--                            <img src="assets/images/avatar/avatar13.webp" alt="Thumbnail Image">--}}
                    {{--                        </div>--}}
                    {{--                        <div class="tmp-lookbook-content-box-wrapper">--}}
                    {{--                            <button class="tmp-lookbook-close-btn"><i class="fas fa-times"></i></button>--}}
                    {{--                            <div class="tmp-lookbook-content-box placed-top">--}}
                    {{--                                <div class="tmp-message-shape"></div>--}}
                    {{--                                <div class="tmp-inner">--}}
                    {{--                                    <p class="b2 tmp-text-heading mb--20">--}}
                    {{--                                        “Professional, knowledgeable, and reliable. They made navigating insurance--}}
                    {{--                                        easy for me.”--}}
                    {{--                                    </p>--}}
                    {{--                                    <div class="tmp-separator tmp-bg-primary-opacity-400 mb--10"></div>--}}
                    {{--                                    <div class="b4 d-flex justify-content-between">--}}
                    {{--                                            <span>--}}
                    {{--                                                <span class="tmp-fw-medium tmp-text-heading">Katherine</span> - UI/UX--}}
                    {{--                                            Designer</span>--}}
                    {{--                                        <span class="tmp-fw-medium">--}}
                    {{--                                                <span>--}}
                    {{--                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
                    {{--                                                         viewBox="0 0 10 15" fill="none">--}}
                    {{--                                                        <path--}}
                    {{--                                                            d="M5.52447 1.15102C5.67415 0.690369 6.32585 0.69037 6.47553 1.15103L7.45934 4.17889C7.52628 4.3849 7.71826 4.52438 7.93487 4.52438H11.1186C11.6029 4.52438 11.8043 5.14419 11.4124 5.42889L8.83679 7.30021C8.66155 7.42753 8.58822 7.65322 8.65516 7.85923L9.63897 10.8871C9.78864 11.3477 9.2614 11.7308 8.86955 11.4461L6.29389 9.57479C6.11865 9.44747 5.88135 9.44747 5.70611 9.57479L3.13045 11.4461C2.73859 11.7308 2.21136 11.3477 2.36103 10.8871L3.34484 7.85923C3.41178 7.65322 3.33845 7.42753 3.16321 7.30021L0.587553 5.42889C0.195696 5.14419 0.397084 4.52438 0.881446 4.52438H4.06513C4.28174 4.52438 4.47372 4.3849 4.54066 4.17889L5.52447 1.15102Z"--}}
                    {{--                                                            fill="#F7A51E"/>--}}
                    {{--                                                    </svg>--}}
                    {{--                                                </span>--}}
                    {{--                                            4.9--}}
                    {{--                                            </span>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <!-- End Single LookBook -->--}}

                </div>
                <div class="tmp-round-blur-shape tmp-round-blur-top-left d-none d-lg-block">
                    <div class="blur-shape-inner"></div>
                </div>
                <div class="tmp-testimonial-bottom-area pb--10">
                    <h4 class="tmp-counter tmp-count tmp-w-fit mx-auto mb--0">
                        <span class="odometer" data-count="{{ 100 + $testimonials->count() }}">00</span>
                        <span class="counter-suffix">+</span>
                    </h4>
                    <p class="mb--5 mt--5">Worldwide Customers Feedback</p>
                    <p class="b3 mb--0 tmp-text-heading tmp-fw-medium">Since 2020</p>
                </div>
            </div>
            <!-- End Testimonial Map Area -->
        </div>
    </section>
    <!-- End Testimonial Area -->

    <!-- Start Brand Style-1  -->
    <div class="tmp-brand-area tmp-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                    <span class="number">4</span>
                                <span class="subtitle-text">Our Awesome Client</span>
                                </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h2 class="title w-700 tmp-title-split">Our Awesome Clients.</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mt--40">
                    <ul class="brand-list brand-style-1">
                        @foreach($partners as $partner)
                            <li><a href="#"><img src="{{ asset($partner->image) }}" alt="Brand Image"></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Brand Style-1  -->


    <!-- Fnd Gallery Large Style-1  -->
    <div class="tmp-gallery-area tmp-section-gapBottom">
        <div class="container-fluid">
            <div class="row mb--40">
                <div class="col-lg-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                    <span class="number">03</span>
                                <span class="subtitle-text">Company Gallery</span>
                                </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h2 class="title w-700 tmp-title-split">Fidelcom Gallery</h2>
                    </div>
                </div>
            </div>
            <div class="row mt_dec--30 row--15" id="animated-lightbox2">
                @foreach($projects as $project)
                    <a class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30" data-sal="slide-up" data-sal-duration="700"
                       href="{{ asset($project->image) }}">
                        <div class="tmp-gallery icon-center">
                            <div class="thumbnail"><img class="radius-small" src="{{ asset($project->image) }}"
                                                        alt="Corporate Image"></div>
                            <div class="video-icon">
                                <div class="btn-default rounded-player sm-size">
                                    <span><i class="feather-zoom-in"></i></span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Fnd Gallery Large Style-1  -->

@endsection
