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
                        <p><small>Whether you're searching for the latest K-Pop albums, timeless merchandise, or hidden gems, our carefully curated collection has something for every Hallyu fan. Our passionate staff is dedicated to helping you find the perfect item, and our cozy, welcoming environment invites you to linger and explore. Join our community of Hallyu lovers and let us help you. Visit us today and experience the joy of getting lost in the world of Hallyu ❤</small></p>
                        <p class="mt-5">Find your gateway to the Korean Wave! Or, even, <span class="text-color-primary">unlock hidden treasures, one album at a time!</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Video Area -->
    <div class="banner-video-area overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-video-box" id="video-banner" style="position: relative; cursor: pointer;">
                    <img id="video-thumbnail" src="{{ asset('asset/hallyu-images/bpdeadline.jpg') }}" alt="Video Thumbnail" class="img-fluid">
                    <div class="video-icon" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        <i class="linear-icon-play" style="font-size: 48px; color: white;"></i>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="font-size: 2rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="youtubePlayer" class="embed-responsive-item" src="" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('addition_css')
@endsection

@section('addition_script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const banner = document.getElementById('video-banner');
    const youtubePlayer = document.getElementById('youtubePlayer');
    const youtubeURL = "https://www.youtube.com/embed/8YiR9v3sOpk?autoplay=1&mute=1";

    if (banner && youtubePlayer) {
        banner.addEventListener('click', function () {
            youtubePlayer.src = youtubeURL;
            $('#videoModal').modal('show');
        });

        $('#videoModal').on('hidden.bs.modal', function () {
            youtubePlayer.src = '';
        });
    }
});
</script>

<!-- JS Slider -->
<script src="{{ asset('asset/js/plugins/slick.min.js') }}"></script>
<script src="{{ asset('pages/js/home.js') }}"></script>
@endsection