@extends('layouts.landing')

@section('main')
<!-- Start Service Area  -->
        <div class="main-content">

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
                                <p>Fidelcom System Limited provides professional IT services in Nigeria and delivers world-class digital solutions to clients globally. Our services are designed to help businesses build strong digital presence, improve operations, and scale using modern technology.</p>
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
                    </div>
                </div>
            </div>
            <!-- End Service__Style--1 Area  -->

        </div>
        <!-- End Service Area  -->
@endsection
