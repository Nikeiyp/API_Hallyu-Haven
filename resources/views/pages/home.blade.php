@extends('layout.app-public')
@section('title', 'Home')

@section('content')
<div class="site-wrapper-reveal">
    <!-- Hero Slider -->
    <div class="hero-box-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-area hero-slider-seven" id="product-preview"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="about-us-area section-space--ptb_120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-us-content_6 text-center">
                        <h2>Hallyu Haven Store</h2>
                        <p><small>Whether you're searching for the latest K-Pop albums, timeless merchandise,
                            or hidden gems, our carefully curated collection has something for every Hallyu fan. Our passionate staff is dedicated to helping you find the perfect item, and our cozy,welcoming environment invites you to linger and explore. Join our community of Hallyu lovers and let us help you. Visit us today and experience the joy of getting lost in the world of Hallyu ❤</small></p>
                        <p class="mt-5">Find your gateway to the Korean Wave! Or, even, <span class="text-color-primary">unlock hidden treasures, one album at a time!</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Banner Video Area Start -->
        <div class="banner-video-area overflow-hidden">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="banner-video-box position-relative text-center">
                            <img src="{{ asset('asset/hallyu-images/gwbg.jpg') }}" alt="video thumbnail" class="img-fluid rounded shadow" style="max-width: 100%; height: auto;">
                            <div class="video-icon">
                                <a href="https://www.youtube.com/watch?v=1KhOhW_O8-k" class="popup-youtube">
                                    <i class="linear-ic-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner Video Area End -->

    <!-- Brand Logo Section -->
    <div class="our-brand-area section-space--pb_90">
        <div class="container">
            <div class="brand-slider-active row">
                @php
                    $brands = ['bplogo', 'exologo', 'btslogo', 'twicelogo', 'itzylogo', 'ikonlogo', 'treasurelogo', 'nctlogo'];
                @endphp
                @foreach ($brands as $logo)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="single-brand-item text-center">
                        <a href="#"><img src="{{ asset('asset/hallyu-images/logo/' . $logo . '.png') }}" class="img-fluid" alt="{{ $logo }}"></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Member Join Area -->
    <div class="our-member-area section-space--pb_120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="member--box">
                        <div class="row align-items-center">
                            <div class="col-lg-5 col-md-4">
                                <div class="section-title small-mb__40 tablet-mb__40">
                                    <h4 class="section-title">Join the community!</h4>
                                    <p>Become one of the member and get discount 50% off</p>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-8">
                                <div class="member-wrap">
                                    <form action="#" class="member--two">
                                        <input class="input-box" type="text" placeholder="Your email address">
                                        <button class="submit-btn"><i class="icon-arrow-right"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('addition_css')

 <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/plugins/magnific-popup.css') }}">

@endsection

@section('addition_script')

<script>
    function setYoutubeVideo(videoId) {
        const iframe = document.getElementById('youtubeIframe');
        iframe.dataset.videoId = videoId; 
    }
</script>

<!-- JS Slider -->
<script src="{{ asset('asset/js/plugins/slick.min.js') }}"></script>
<script src="{{ asset('pages/js/home.js') }}"></script>
@endsection