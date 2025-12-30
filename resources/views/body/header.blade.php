<header class="tmp-header header-default header-left-align header-not-transparent header-sticky-smooth header-sticky">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-9 col-md-6 col-4 position-static">
                <div class="header-left d-flex">
                    <div class="logo">
                        <a href="/">
                            <img class="logo-light" src="{{ asset('assets/images/logo/Fidelcomw.png') }}" alt="Corporate Logo">
                            <img class="logo-dark" src="{{ asset('assets/images/logo/Fidelcom1.png') }}" alt="Corporate Logo">
                        </a>
                    </div>
                    <nav class="mainmenu-nav d-none d-lg-block">
                        <ul class="mainmenu">
                            <li class="with-megamenu"><a href="/">Home</a>

                            </li>

                            <li><a href="{{ route('about.home') }}">About</a></li>

                            <li><a href="{{ route('all-services.index') }}">Service</a>
                            </li>
                            <li class="has-droupdown has-menu-child-item"><a href="{{ route('all-projects.index') }}">Project</a>
                                <ul class="submenu">
                                    <li><a href="portfolio.html">Portfolio Default</a></li>
                                    <li><a href="portfolio-three-column.html">Portfolio Three Column</a></li>
                                    <li><a href="portfolio-full-width.html">Portfolio Full Width</a></li>
                                    <li><a href="portfolio-grid-layout.html">Portfolio Grid Layout</a></li>
                                    <li><a href="portfolio-box-layout.html">Portfolio Box Layout</a></li>
                                    <li><a href="portfolio-card-hover.html">Portfolio Card Hover</a></li>
                                    <li><a href="portfolio-bottom-content.html">Portfolio Bottom Content</a></li>
                                    <li class="has-third-lev">
                                        <a href="#">Portfolio Details</a>
                                        <ul class="submenu">
                                            <li><a href="portfolio-details.html">Portfolio Details</a></li>
                                            <li><a href="portfolio-details-two.html">Portfolio Details Two</a></li>
                                            <li><a href="portfolio-details-three.html">Portfolio Details Video</a></li>
                                            <li><a href="portfolio-details-five.html">Portfolio Details Video 2</a></li>
                                            <li><a href="portfolio-details-four.html">Portfolio Details Slider</a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <li><a href="{{ route('blog') }}">Blog</a>
                            </li>

                            <li><a href="{{ route('contact.us') }}">Contact</a></li>
                        </ul>







                    </nav>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-8">
                <div class="header-right with-search">
                    <div class="header-btn">
                        <div class="search-area-btn cursor-pointer" id="search">
                            <i class="feather-search"></i>
                            <!-- <img src="assets/images/icons/search.svg" alt="Business"> -->
                        </div>
                        <div class="dot-btn">
                            <!-- <img src="assets/images/shop/dot.svg" alt=""> -->
                            <span class="offcanvas-trigger">
                                <span class="offcanvas-bars">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    </span>
                                    </span>
                        </div>
                        <a class="tmp-btn btn-small round" target="_blank" href="{{ route('contact.us') }}">REQUEST A QUOTE</a>
                    </div>

                    <!-- Start Mobile-Menu-Bar -->
                    <div class="mobile-menu-bar ml--5 d-block d-lg-none">
                        <div class="hamberger">
                            <button class="hamberger-button">
                                <i class="feather-menu"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Start Mobile-Menu-Bar -->
                </div>
            </div>
        </div>
    </div>
</header>
<div class="popup-mobile-menu">
    <div class="inner">
        <div class="header-top">
            <div class="logo">
                <a href="/">
                    <img class="logo-light" src="{{ asset('assets/images/logo/Fidelcomw.png') }}" alt="Corporate Logo">
                    <img class="logo-dark" src="{{ asset('assets/images/logo/Fidelcom1.png') }}" alt="Corporate Logo">
                </a>
            </div>
            <div class="close-menu">
                <button class="close-button">
                    <i class="feather-x"></i>
                </button>
            </div>
        </div>
        <ul class="mainmenu">
            <li><a href="/">Home</a>
            </li>
            <li><a href="{{ route('about.home') }}">About</a>
            </li>
            <li><a href="{{ route('all-services.index') }}">Service</a>
            </li>
            <li class="has-droupdown has-menu-child-item"><a href="{{ route('all-projects.index') }}">Project</a>
                <ul class="submenu">
                    <li><a href="portfolio.html">Portfolio Default</a></li>
                    <li><a href="portfolio-three-column.html">Portfolio Three Column</a></li>
                    <li><a href="portfolio-full-width.html">Portfolio Full Width</a></li>
                    <li><a href="portfolio-grid-layout.html">Portfolio Grid Layout</a></li>
                    <li><a href="portfolio-box-layout.html">Portfolio Box Layout</a></li>
                    <li><a href="portfolio-card-hover.html">Portfolio Card Hover</a></li>
                    <li><a href="portfolio-bottom-content.html">Portfolio Bottom Content</a></li>
                    <li class="has-third-lev">
                        <a href="#">Portfolio Details</a>
                        <ul class="submenu">
                            <li><a href="portfolio-details.html">Portfolio Details</a></li>
                            <li><a href="portfolio-details-two.html">Portfolio Details Two</a></li>
                            <li><a href="portfolio-details-three.html">Portfolio Details Video</a></li>
                            <li><a href="portfolio-details-five.html">Portfolio Details Video 2</a></li>
                            <li><a href="portfolio-details-four.html">Portfolio Details Slider</a></li>
                        </ul>
                    </li>

                </ul>
            </li>
            <li><a href="{{ route('blog') }}">Blog</a>
            </li>

            <li><a href="{{ route('contact.us') }}">Contact</a></li>

        </ul>







    </div>
</div>
