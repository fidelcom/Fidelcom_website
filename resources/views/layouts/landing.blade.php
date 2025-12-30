<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from html.inversweb.com/corpox/02-index-business-consulting-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Nov 2025 07:07:35 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-style-mode" content="1">
    <meta name="description" content="Transform your business with expert consulting. Our team delivers strategic insights, innovative solutions, and professional guidance to help you achieve lasting success.">

    <title>{{ env('app_name') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <!-- CSS ============================================ -->

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet">
    <!-- google fonts end-->

    <link href="{{ asset('assets/css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/animation.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/feature.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/magnify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/lightbox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/odometer.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/stylea3ca.css?v=4.2.9') }}">
</head>

<body>
    <main class="page-wrapper">
        <!-- Start Header Top Area  -->

        @include('body.header')

        @yield('main')



        <!-- Start Footer Area  -->
        @include('body.footer')
        <!-- End Footer Area  -->
    </main>

    <!-- All Scripts  -->

    <!-- pre loader start -->

    <!-- <div id="inverweb-load">
    <span class="loader"></span>
</div> -->

    <!-- pre loader end -->





    <div id="anywhere-home" class="">
    </div>


    <div class="tmp-search-input-area">
        <div class="container">
            <div class="search-input-inner">
                <form action="#" class="input-div tmponhover">
                    <input id="searchInput1" class="search-input" type="text" placeholder="🔎 Search products, topics, or #tags" required>
                    <button>
                        <!-- <img src="assets/images/icons/search.svg" alt=""> -->
                        <i class="feather-search"></i>
                    </button>
                </form>
                <div class="popular-keyword">
                    <h4 class="title">Popular Tag :</h4>
                    <div class="tag-wrapper">
                        <a class="tmp-btn btn-border btn-small radius-round" href="#">Service</a>
                        <a class="tmp-btn btn-border btn-small radius-round" href="#">Business</a>
                        <a class="tmp-btn btn-border btn-small radius-round" href="#">Consultancy</a>
                    </div>
                </div>
                <div class="row g-5 service-wrapper mt--10 mt_md--10 mt_sm--0">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 sal-animate">
                        <div class="card-box card-style-1 text-left tmponhover" style="--x: 270px; --y: 7px;">
                            <div class="inner">
                                <div class="image">
                                    <a href="#">
                                        <img src="assets/images/services/serviice-01.jpg" alt="card Images">
                                    </a>
                                </div>
                                <div class="content">
                                    <h4 class="title mb--20"><a href="#">Awarded Design</a>
                                    </h4>
                                    <div class="discover-btn">
                                        <a class="tmp-btn mt--0 round btn-small btn-border hover-icon-reverse" href="#">
                                            <span class="icon-reverse-wrapper">
                    <span class="btn-text">See More</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 sal-animate">
                        <div class="card-box card-style-1 text-left tmponhover" style="--x: 12px; --y: 31px;">
                            <div class="inner">
                                <div class="image">
                                    <a href="#">
                                        <img src="assets/images/services/serviice-02.jpg" alt="card Images">
                                    </a>
                                </div>
                                <div class="content">
                                    <h4 class="title mb--20"><a href="#">Design &amp;
                                            Creative</a>
                                    </h4>
                                    <div class="discover-btn">
                                        <a class="tmp-btn mt--0 round btn-small btn-border hover-icon-reverse" href="#">
                                            <span class="icon-reverse-wrapper">
                    <span class="btn-text">See More</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 sal-animate">
                        <div class="card-box card-style-1 text-left tmponhover" style="--x: 15px; --y: 99px;">
                            <div class="inner">
                                <div class="image">
                                    <a href="#">
                                        <img src="assets/images/services/serviice-03.jpg" alt="card Images">
                                    </a>
                                </div>
                                <div class="content">
                                    <h4 class="title mb--20"><a href="#">App Development</a>
                                    </h4>
                                    <div class="discover-btn">
                                        <a class="tmp-btn mt--0 round btn-small btn-border hover-icon-reverse" href="#">
                                            <span class="icon-reverse-wrapper">
                    <span class="btn-text">See More</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 sal-animate">
                        <div class="card-box card-style-1 text-left tmponhover" style="--x: 15px; --y: 99px;">
                            <div class="inner">
                                <div class="image">
                                    <a href="#">
                                        <img src="assets/images/services/serviice-04.jpg" alt="card Images">
                                    </a>
                                </div>
                                <div class="content">
                                    <h4 class="title mb--20"><a href="#">UI/UX Design</a>
                                    </h4>
                                    <div class="discover-btn">
                                        <a class="tmp-btn mt--0 round btn-small btn-border hover-icon-reverse" href="#">
                                            <span class="icon-reverse-wrapper">
                    <span class="btn-text">See More</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="close" class="search-close-icon tmponhover">
            <img src="assets/images/icons/close.png" alt="">
        </div>
        <div class="bg-text">consultancy</div>
    </div>

    <!--
<div class="mouse-cursor cursor-outer"></div>
<div class="mouse-cursor cursor-inner"></div> -->

    <div class="scrollbar-v show-on-scroll"></div>
    <div class="float-text show-on-scroll">
        <span><a href="#">Scroll to top</a></span>
    </div>


    <!-- sidebar desktop -->
    <div class="inverweb-side-bar-close">
        <div class="shape-right-top">
            <img src="{{ asset('assets/images/banner/shape-it-1.svg') }}" alt="">
        </div>
        <button class="close-icon-menu tmponhover"><i class="feather-x"></i></button>
        <div class="logo-side">
            <a href="/">
                <img class="logo-light" src="{{ asset('assets/images/logo/Fidelcomw.png') }}" alt="Corporate Logo">
                <img class="logo-dark" src="{{ asset('assets/images/logo/Fidelcom1.png') }}" alt="Corporate Logo">
            </a>
        </div>
        @php
            $contact = \App\Models\Contact::first();
            $projects = \App\Models\Project::all();
        @endphp
        <div class="side-info">
            <div class="contact-list">
                <h4>Office Address</h4>
                <p>{{ $contact->address }}</p>
            </div>
            <div class="contact-list">
                <h4>Phone Number</h4>
                <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
{{--                <a href="tel:+8801712345678">+(090) 8765 86543 85</a>--}}
            </div>
            <div class="contact-list">
                <h4>Email Address</h4>
                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
{{--                <a href="mailto:info@yourdomain.com">example.mail@hum.com</a>--}}
            </div>
        </div>

        <div class="row g-3 mt--15" id="animated-lightbox2">
            @foreach($projects as $project)
                <a class="col-lg-4 col-md-6 col-sm-6 col-12" href="{{ asset($project->image) }}">
                    <div class="tmp-gallery icon-center">
                        <div class="thumbnail"><img class="radius-small" src="{{ asset($project->image) }}" alt="Corporate Image"></div>
                        <div class="video-icon">
                            <div class="btn-default rounded-player sm-size">
                                <span><i class="feather-zoom-in"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <ul class="social-icon social-default justify-content-start mt--30">
            <li><a href="{{ $contact->facebook }}">
                    <i class="feather-facebook"></i>
                </a>
            </li>
            <li><a href="{{ $contact->twitter }}">
                    <i class="feather-twitter"></i>
                </a>
            </li>
            <li><a href="{{ $contact->instagram }}">
                    <i class="feather-instagram"></i>
                </a>
            </li>
            <li><a href="{{ $contact->linkedin }}">
                    <i class="feather-linkedin"></i>
                </a>
            </li>
        </ul>

    </div>
    <!-- sidebar desktop end -->


    <!-- JS
============================================ -->
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/waypoint.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/wow.min.js') }}" defer></script>

    <script src="{{ asset('assets/js/vendor/feather.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/sal.min.js') }}" defer></script>


    <!-- gsap animation start -->
    <script src="{{ asset('assets/js/plugins/gsap.js') }}" defer></script>
    <script src="{{ asset('assets/js/plugins/scrolltigger.js') }}" defer></script>
    <script src="{{ asset('assets/js/plugins/splittext.js') }}" defer></script>
    <!-- gsap animation end -->


    <script src="{{ asset('assets/js/vendor/masonry.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/imageloaded.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/magnify.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/lightbox.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/slick.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/easypie.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/text-type.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/jquery-one-page-nav.js') }}" defer></script>

    <script src="{{ asset('assets/js/plugins/smoothscroll.js') }}" defer></script>

    <script src="{{ asset('assets/js/plugins/odometer.js') }}" defer></script>

    <script src="{{ asset('assets/js/plugins/jaralax.js') }}" defer></script>
    <script src="{{ asset('assets/js/plugins/scroll-elements.js') }}" defer></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}" defer></script>

</body>


</html>
