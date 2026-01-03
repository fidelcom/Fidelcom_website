<footer class="tmp-footer footer-style-default variation-two position-relative">

    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="tmp-footer-widget">
                        <div class="logo">
                            <a href="/">
                                <img class="logo-light" src="{{ asset('assets/images/logo/Fidelcomw.png') }}" alt="Corporate Logo">
                                <img class="logo-dark" src="{{ asset('assets/images/logo/Fidelcom1.png') }}" alt="Corporate Logo">
                            </a>
                        </div>
                        <p class="subtitle mt--30">Fidelcom is an IT consulting firm helping businesses succeed.

                            Technology, Information and Internet</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="tmp-footer-widget">
                        <h4 class="title">Company</h4>
                        <div class="inner">
                            <ul class="footer-link link-hover">
                                <li><a href="pricing.html">Pricing</a></li>
                                <li><a href="tab.html">Tab Styles</a></li>
                                <li><a href="service.html">Service</a></li>
                                <li><a href="social-share.html">Social</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="tmp-footer-widget">
                        <h4 class="title">Resources</h4>
                        <div class="inner">
                            <ul class="footer-link link-hover">
                                <li><a href="#">Team</a></li>
                                <li><a href="#">Testimonial</a></li>
                                <li><a href="{{ route('all-services.index') }}">Service</a></li>
                                <li><a href="#">Timeline</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                @php
                    $contact = \App\Models\Contact::first();
//                    $projects = \App\Models\Project::all();
                @endphp
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="tmp-footer-widget">
                        <h4 class="title">Stay With Us.</h4>
                        <div class="inner">
                            <h6 class="subtitle">1200+ trusted clients are subscribe Us around the world</h6>
                            <ul class="social-icon social-default justify-content-start">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="jumping-text">
<h2 class="title end">
    Contact Us
</h2>
</div> -->

    <!-- Start Copy Right Area  -->
    <div class="copyright-area copyright-style-one">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8 col-sm-12 col-12">
                    <div class="copyright-left">
                        <ul class="ft-menu link-hover">
                            <li>
                                <a href="#">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="#">Terms And Condition</a>
                            </li>
                            <li>
                                <a href="{{ route('contact.us') }}">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4 col-sm-12 col-12">
                    <div class="copyright-right text-center text-lg-end">
                        <p class="copyright-text">All Right Reserved © {{ env('app_name') }}
                            <span id="year"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Copy Right Area  -->
    <div class="shape-area wow move-right" data-wow-offset="250">
        <img src="{{ asset('assets/images/shape/02.png') }}" alt="consulting_business">
    </div>
</footer>
