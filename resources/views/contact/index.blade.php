@extends('layouts.landing')

@section('main')
<!-- Start Contact Area  -->
        <div class="main-content">

            <div class="tmp-contact-area tmp-section-gap">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tmp-section-title-border text-center">
                                <div class="pres-line-separator-wrapper text-center mb--10">
                                    <div class="line-separator line-left"></div>
                                    <span class="subtitle">
                                        <span class="number"><a href="/">01</a></span>
                                    <span class="subtitle-text">Contact With Us</span>
                                    </span>
                                    <div class="line-separator line-right"></div>
                                </div>
                                <h2 class="title w-700 mt--20 tmp-title-split">Let's Contact With Us</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row g-5 mt--30">
                        <div class="col-lg-12">
                            <div class="tmp-contact-address mt_dec--30">
                                <div class="row g-5">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="tmp-address tmponhover">
                                            <div class="icon">
                                                <i class="feather-headphones"></i>
                                            </div>
                                            <div class="inner">
                                                <h4 class="title">Call us today</h4>
                                                <p><a href="#">{{ $contact->phone }}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="tmp-address tmponhover">
                                            <div class="icon">
                                                <i class="feather-mail"></i>
                                            </div>
                                            <div class="inner">
                                                <h4 class="title">Send an Email</h4>
                                                <p><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="tmp-address tmponhover">
                                            <div class="icon">
                                                <i class="feather-map-pin"></i>
                                            </div>
                                            <div class="inner">
                                                <h4 class="title">Visit our HQ</h4>
                                                <p>{{ $contact->address }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <!-- appoinment area start -->
            <div class="inv-appoinment-area-start tmp-section-gapBottom">
                <div class="container">
                    <div class="row g-5">

                        <div class="col-lg-5">
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

            <div class="tmp-map-area tmp-section-gapBottom">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-12 sal-animate">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d235495.62780269101!2d-73.932551722484!3d41.33466214858558!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e1!3m2!1sen!2sbd!4v1637254792714!5m2!1sen!2sbd" height="550" style="border:0;" allowfullscreen="" loading="lazy" spellcheck="false" aria-label="To enrich screen reader interactions, please activate Accessibility in Grammarly extension settings"></iframe>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Contact Area  -->
@endsection
