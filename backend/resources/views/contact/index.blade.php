@extends('layouts.landing')

@section('page_title', 'Contact Us | ' . config('app.name'))
@section('meta_description', 'Get in touch with Fidelcom Systems Limited. Request a quote, send a message, or visit us in Lekki, Lagos, Nigeria.')
@section('canonical_url', route('contact.us'))

@section('main')
<!-- Start Contact Area  -->
<div class="main-content">

    {{-- ── Section header ─────────────────────────────────────────── --}}
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
                        <h2 class="title w-700 mt--20 tmp-title-split">Let's Work Together</h2>
                    </div>
                </div>
            </div>

            {{-- ── Contact info cards ──────────────────────────────── --}}
            <div class="row g-5 mt--30">
                <div class="col-lg-12">
                    <div class="tmp-contact-address mt_dec--30">
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="tmp-address tmponhover">
                                    <div class="icon"><i class="feather-headphones"></i></div>
                                    <div class="inner">
                                        <h4 class="title">Call us today</h4>
                                        <p><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="tmp-address tmponhover">
                                    <div class="icon"><i class="feather-mail"></i></div>
                                    <div class="inner">
                                        <h4 class="title">Send an Email</h4>
                                        <p><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="tmp-address tmponhover">
                                    <div class="icon"><i class="feather-map-pin"></i></div>
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

    {{-- ── Request a Quote form ────────────────────────────────────── --}}
    <div class="inv-appoinment-area-start tmp-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb--40">
                    <div class="pres-line-separator-wrapper text-center mb--10">
                        <div class="line-separator line-left"></div>
                        <span class="subtitle">
                            <span class="number"><a href="/">02</a></span>
                            <span class="subtitle-text">Get a Price</span>
                        </span>
                        <div class="line-separator line-right"></div>
                    </div>
                    <h2 class="title w-700 mt--20 tmp-title-split">Request a Quote</h2>
                    <p class="mt--15" style="max-width:600px;margin:0 auto;">Tell us about your project and we'll get back to you with a tailored proposal within 24 hours.</p>
                </div>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-lg-8">
                    <form class="contact-form-1 appoinment-form-wrapper tmponhover tmp-dynamic-form"
                          id="quote-form"
                          method="POST"
                          action="{{ route('contact.us.store') }}">
                        @csrf

                        {{-- Row 1: Name + Phone --}}
                        <div class="form-group-wrapper">
                            <div class="form-group tmponhover">
                                <input type="text" name="name" placeholder="Your Full Name *" required>
                            </div>
                            <div class="form-group tmponhover">
                                <input type="tel" name="phone" placeholder="Phone Number *" required>
                            </div>
                        </div>

                        {{-- Row 2: Email + Company --}}
                        <div class="form-group-wrapper">
                            <div class="form-group tmponhover">
                                <input type="email" name="email" placeholder="Email Address *" required>
                            </div>
                            <div class="form-group tmponhover">
                                <input type="text" name="company" placeholder="Company / Organisation (optional)">
                            </div>
                        </div>

                        {{-- Service select → becomes subject --}}
                        <div class="form-group tmponhover">
                            <select name="subject" required
                                style="width:100%;padding:15px 20px;border:1px solid #e8e8e8;border-radius:6px;background:#fff;color:#6b6b6b;font-size:15px;appearance:none;-webkit-appearance:none;cursor:pointer;outline:none;">
                                <option value="" disabled selected>Select Service You Need *</option>
                                @foreach($services as $service)
                                    <option value="Quote Request – {{ $service->title }}">{{ $service->title }}</option>
                                @endforeach
                                <option value="Quote Request – Other">Other / Not Listed</option>
                            </select>
                        </div>

                        {{-- Budget --}}
                        <div class="form-group tmponhover">
                            <select name="budget"
                                style="width:100%;padding:15px 20px;border:1px solid #e8e8e8;border-radius:6px;background:#fff;color:#6b6b6b;font-size:15px;appearance:none;-webkit-appearance:none;cursor:pointer;outline:none;">
                                <option value="" disabled selected>Estimated Budget (optional)</option>
                                <option value="Under ₦500,000">Under ₦500,000</option>
                                <option value="₦500,000 – ₦1,000,000">₦500,000 – ₦1,000,000</option>
                                <option value="₦1,000,000 – ₦5,000,000">₦1,000,000 – ₦5,000,000</option>
                                <option value="₦5,000,000 – ₦10,000,000">₦5,000,000 – ₦10,000,000</option>
                                <option value="Above ₦10,000,000">Above ₦10,000,000</option>
                                <option value="To be discussed">To be discussed</option>
                            </select>
                        </div>

                        {{-- Project description → message --}}
                        <div class="form-group tmponhover">
                            <textarea name="message" rows="5"
                                placeholder="Briefly describe your project or requirements *"
                                required></textarea>
                        </div>

                        <div class="form-group tmponhover">
                            <button name="submit" type="submit" class="btn-default btn-large tmp-btn" style="width:100%;">
                                <span>Submit Quote Request</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ── General contact / send a message ──────────────────────── --}}
    <div class="inv-appoinment-area-start tmp-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb--40">
                    <div class="pres-line-separator-wrapper text-center mb--10">
                        <div class="line-separator line-left"></div>
                        <span class="subtitle">
                            <span class="number"><a href="/">03</a></span>
                            <span class="subtitle-text">Send a Message</span>
                        </span>
                        <div class="line-separator line-right"></div>
                    </div>
                    <h2 class="title w-700 mt--20 tmp-title-split">General Enquiry</h2>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="aapoiment-left-area-thumbnail">
                        <img src="{{ asset('assets/images/appoinment/01.webp') }}" alt="Contact Fidelcom" style="width:100%;border-radius:10px;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <form class="contact-form-1 appoinment-form-wrapper tmponhover tmp-dynamic-form"
                          id="contact-form"
                          method="POST"
                          action="{{ route('contact.us.store') }}">
                        @csrf
                        <div class="form-group-wrapper">
                            <div class="form-group tmponhover">
                                <input type="text" name="name" placeholder="Your Name *" required>
                            </div>
                            <div class="form-group tmponhover">
                                <input type="tel" name="phone" placeholder="Phone Number *" required>
                            </div>
                        </div>
                        <div class="form-group tmponhover">
                            <input type="email" name="email" placeholder="Your Email *" required>
                        </div>
                        <div class="form-group tmponhover">
                            <input type="text" name="subject" placeholder="Subject *" required>
                        </div>
                        <div class="form-group tmponhover">
                            <textarea name="message" placeholder="Your Message *" required></textarea>
                        </div>
                        <div class="form-group tmponhover">
                            <button name="submit" type="submit" class="btn-default btn-large tmp-btn" style="width:100%;">
                                <span>Send Message</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Map — Lekki, Lagos, Nigeria ───────────────────────────── --}}
    <div class="tmp-map-area tmp-section-gapBottom">
        <div class="container">
            <div class="row g-5">
                <div class="col-12 sal-animate">
                    <iframe
                        src="https://maps.google.com/maps?q=Lekki+Phase+1+Lagos+Nigeria&t=&z=14&ie=UTF8&iwloc=&output=embed"
                        height="550"
                        style="border:0;width:100%;border-radius:10px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Fidelcom Systems Limited — Lekki, Lagos, Nigeria">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Contact Area  -->
@endsection
