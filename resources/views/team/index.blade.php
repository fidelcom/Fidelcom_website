@extends('layouts.landing')

@section('page_title', 'Our Team | ' . config('app.name'))
@section('meta_description', 'Meet the Fidelcom Systems team — skilled professionals delivering IT solutions, software development, and digital consulting across Nigeria and beyond.')

@section('main')

    <!-- Start Breadcrumb Area -->
    <div class="tmp-breadcrumb-area ptb--60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h1 class="title">Our Team</h1>
                        <ul class="page-list">
                            <li class="tmp-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="tmp-breadcrumb-item active">Our Team</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <!-- Start Team Area -->
    <div class="tmp-team-area tmp-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tmp-section-title-border text-center">
                        <div class="pres-line-separator-wrapper text-center mb--10">
                            <div class="line-separator line-left"></div>
                            <span class="subtitle">
                                <span class="subtitle-text">MEET THE TEAM</span>
                            </span>
                            <div class="line-separator line-right"></div>
                        </div>
                        <h2 class="title w-700">The People Behind Fidelcom</h2>
                        <p class="description b1">Dedicated professionals committed to delivering world-class IT and digital solutions.</p>
                    </div>
                </div>
            </div>

            <div class="row g-5 mt--30">
                @forelse($team as $member)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12" data-sal="slide-up" data-sal-duration="700">
                        <div class="team-style-default tmponhover">
                            <div class="thumbnail">
                                <img loading="lazy" src="{{ asset($member->image) }}" alt="{{ $member->name }}">
                            </div>
                            <div class="content">
                                <h4 class="title">{{ $member->name }}</h4>
                                <h6 class="subtitle theme-gradient">{{ $member->position }}</h6>
                                <div class="team-form">
                                    <div class="social-icon">
                                        @if($member->linkedin)
                                            <a href="{{ $member->linkedin }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $member->name }} on LinkedIn">
                                                <i class="feather-linkedin"></i>
                                            </a>
                                        @endif
                                        @if($member->twitter)
                                            <a href="{{ $member->twitter }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $member->name }} on Twitter">
                                                <i class="feather-twitter"></i>
                                            </a>
                                        @endif
                                        @if($member->instagram)
                                            <a href="{{ $member->instagram }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $member->name }} on Instagram">
                                                <i class="feather-instagram"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Team information coming soon.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- End Team Area -->

@endsection
