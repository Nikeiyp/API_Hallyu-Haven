<header class="header-area header-area--default bg-white">
    <!-- Header Bottom Wrap Start -->
    <div class="header-area--default bg-white header-sticky">
        <div class="container-fluid container-fluid--cp-100">
            <div class="row">
                <div class="col-xl-2 d-none d-md-block">
                    <div class="logo-top-area">
                        <div class="logo text-md-center">
                            <a href="{{ route('home') }}"><img src="{{asset('asset/images/logo/logo.png')}}" class="logo" style="width:40%"></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-6">
                    <div class="header-right-items content_hidden d-none d-md-block">
                        <span class="phone-number font-lg"><i class="icon-telephone"></i>&nbsp;&nbsp;<small class="text-color-primary">(+62) 85212345678</small></span>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-6">
                    <div class="logo_hidden text-start">
                        <a href="{{ route('home') }}"><img src="{{asset('asset/images/logo/logo.png')}}" alt="" style="height:40px"></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="header-navigation d-none d-lg-block">
                        <ul class="justify-content-center">
                            <li>
                                <a href="{{route('home')}}"><span>Home</span></a>
                            </li>
                            <li>
                                <a href="{{route('plp')}}"><span>Shop</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="header-right-side text-end">
                        <div class="header-right-items d-none d-md-block">
                            <a href="{{route('cart')}}"><i class="icon-basket-loaded"></i>
                                <span class="item-counter">3</span>
                            </a>
                        </div>
                        <div class="header-right-items d-none d-md-block">
                            @if (ISSET($CUSER))
                                <div class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <a class="dropdown-toggle"><span>My Profile</span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">{{$CUSER['name']}}</a></li>
                                        <li><a id="logout-btn" href="#">Logout</a></li>
                                    </ul>
                                </div>
                            @else
                                <a href="#" data-bs-toggle="modal" data-bs-target="#authModal">
                                    <i class="icon-user"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of header area -->

    <div class="header-login-register-wrapper modal fade" id="authModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-tab-menu nav">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_list_06" role="tab">Login</a>
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_list_07" role="tab">Our Register</a>
                </div>
                <div class="tab-content content-modal-box">
                    <div class="tab-pane fade show active" id="tab_list_06" role="tabpanel">
                        <form class="auth-form-box" id="form-login">
                            <div class="single-input">
                                <input class="form-control" type="email" placeholder="Email" required>
                            </div>
                            <div class="single-input">
                                <input class="form-control" type="password" placeholder="Password" required>
                            </div>
                            <div class="checkbox-wrap mt-10">
                                <label class="checkbox-style">
                                    <input class="checkbox" name="remember" type="checkbox" id="remember" value="forever">
                                    <span></span>
                                </label>
                                <p><a href="#" class="reset-pass">Lost your password?</a></p>
                            </div>
                            <div class="button-box mt-25">
                                <button class="btn btn-block btn-black btn-hover-primary font-weight-bold" id="form-login-btn">Log in</button>
                            </div>
                            <div class="login-loading" style="text-align:center;display:none;">
                                <img src="{{asset('assets/images/loading.gif')}}" style="width: 30px;">
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_list_07" role="tabpanel">
                        <form class="auth-form-box" id="form-register">
                            <div class="single-input">
                                <input class="form-control" type="text" placeholder="Full Name" required>
                            </div>
                            <div class="single-input">
                                <input class="form-control" type="email" placeholder="Email Address" required>
                            </div>
                            <div class="single-input">
                                <input class="form-control" type="password" placeholder="Password" required>
                            </div>
                            <div class="single-input">
                                <input class="form-control" type="password" placeholder="Confirm Password" required>
                            </div>
                            <div class="checkbox-wrap mt-10">
                                <label class="checkbox-style">
                                    <input class="checkbox" type="checkbox">
                                    <span></span>
                                </label>
                                <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#" class="text-color-primary hover-underline">privacy policy</a>.</p>
                            </div>
                            <div class="button-box mt-25">
                                <button class="btn btn-block btn-black btn-hover-primary font-weight-bold" id="form-register-btn">Register</button>
                            </div>
                            <div class="register-loading" style="text-align:center;display:none;">
                                <img src="{{asset('assets/images/loading.gif')}}" style="width: 30px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
