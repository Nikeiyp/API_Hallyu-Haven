@extends('layout.app-public')
@section('title', 'Home')
@section('content')
    <div class="site-wrapper-reveal">
        <div class="hero-box-area">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-12">
                        <!-- Hero Slider Area Start -->
                        <div class="hero-area" id="product-preview">
                        </div>
                        <!-- Hero Slider Area End -->
                    </div>
                </div>
            </div>
        </div>

        <div class="about-us-area section-space--ptb_120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="about-us-content_6 text-center">
                            <h2>Jeje's&nbsp;&nbsp;World&nbsp;&nbsp;of<br>Books</h2>
                            <p>
                                <small>
                                    Whether you're searching for a the latest bestsellers, timeless classics,
                                    or hidden gems, our carefully curated collection has something for everyone.
                                    Our passionate staff is dedicated to helping you find the perfect read,
                                    and our cozy, welcoming environment invites you to linger
                                    and explore. Join our community of book lovers and let us help you.
                                    Visit us today and experience the joy of getting lost in a great book &#10084;
                                </small>
                            </p>
                            <p class="mt-5">Find your window to the world! Or, even,
                                <span class="text-color-primary">unlock hidden worlds, one page at a time!</span>
                            </p>
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
<!-- Banner Video Area End -->

        <!-- Our Brand Area Start -->
<div class="our-brand-area section-space--pb_90">
    <div class="container">
        <div class="brand-slider-active">
            <div class="col-lg-12">
                <div class="single-brand-item">
                    <a href="#"><img src="asset/hallyu-images/logo/bplogo.png" class="img-fluid" alt="Brand Images"></a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="single-brand-item">
                    <a href="#"><img src="asset/hallyu-images/logo/exologo.png" class="img-fluid" alt="Brand Images"></a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="single-brand-item">
                    <a href="#"><img src="asset/hallyu-images/logo/btslogo.png" class="img-fluid" alt="Brand Images"></a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="single-brand-item">
                    <a href="#"><img src="asset/hallyu-images/logo/twicelogo.png" class="img-fluid" alt="Brand Images"></a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="single-brand-item">
                    <a href="#"><img src="asset/hallyu-images/logo/itzylogo.png" class="img-fluid" alt="Brand Images"></a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="single-brand-item">
                    <a href="#"><img src="asset/hallyu-images/logo/ikonlogo.png" class="img-fluid" alt="Brand Images"></a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="single-brand-item">
                    <a href="#"><img src="asset/hallyu-images/logo/treasurelogo.png" class="img-fluid" alt="Brand Images"></a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="single-brand-item">
                    <a href="#"><img src="asset/hallyu-images/logo/nctlogo.png" class="img-fluid" alt="Brand Images"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Our Brand Area End -->


        <!-- Our Member Area Start -->
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
        <!-- Our Member Area End -->

    </div>
@endsection
@section('addition_css')
@endsection

@section('addition_script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const banner = document.getElementById('video-banner');
        const thumbnailHTML = banner.innerHTML;

        banner.addEventListener('mouseenter', function () {
            banner.innerHTML = `
                <iframe width="100%" height="650" src="https://www.youtube.com/embed/8YiR9v3sOpk?autoplay=1&mute=1&rel=0&showinfo=0&modestbranding=1"
                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>`;
        });

        banner.addEventListener('mouseleave', function () {
            banner.innerHTML = thumbnailHTML;
        });
    });
</script>

<script src="{{asset('pages/js/home.js')}}"></script>
@endsection