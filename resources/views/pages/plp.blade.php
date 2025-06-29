@extends('layout.app-public')
@section('title', 'Shop')
@section('content')
    <div class="site-wrapper-reveal">
        <!-- Product Area Start -->
        <div class="product-wrapper section-space--ptb_90 border-bottom pb-5 mb-5">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 col-md-3 order-md-1 order-2 small-mt__40">
                        <!-- Type Filter -->
                        <div class="shop-widget widget-shop-publishers mt-3">
                            <div class="product-filter">
                                <h6 class="mb-20">Type</h6>
                                    <select class="_filter form-select form-select-sm" name="_type" onchange="getData(1)">
                                        <option value="" selected>All</option>
                                        <option value="lightstick">Lightstick</option>
                                        <option value="album">Album</option>
                                    </select>
                            </div>
                        </div>

                        <!-- Color Filter-->

                        <!-- Price Filter -->
                        <div class="shop-widget">
                            <div class="product-filter widget-price">
                                <h6 class="mb-20">Price</h6>
                                <ul class="widget-nav-list">
                                    <li><a href="javascript:;" name="_price_range" data-value="under_100" onclick="setFilter(this)">Under IDR 100K</a></li>
                                    <li><a href="javascript:;" name="_price_range" data-value="100_500" onclick="setFilter(this)">IDR 100-500K</a></li>
                                    <li><a href="javascript:;" name="_price_range" data-value="501_1000" onclick="setFilter(this)">IDR 501-1000K</a></li>
                                    <li><a href="javascript:;" name="_price_range" data-value="above_1000" onclick="setFilter(this)">Above IDR 1000K</a></li>
                                </ul>
                                <button class="btn btn-sm btn-outline-secondary mt-2" onclick="clearPriceFilter()">Clear Price Filter</button>
                            </div>
                        </div>

                        <!-- Tags Filter -->
                        <div class="shop-widget">
                            <div class="product-filter">
                                <h6 class="mb-20">Tags</h6>
                                <div class="blog-tagcloud">
                                    <a href="javascript:;" name="_tags" data-value="bts" onclick="setTag('bts')">BTS</a>
                                    <a href="javascript:;" name="_tags" data-value="exo" onclick="setTag('exo')">EXO</a>
                                    <a href="javascript:;" name="_tags" data-value="twice" onclick="setTag('twice')">TWICE</a>
                                    <a href="javascript:;" name="_tags" data-value="blackpink" onclick="setTag('blackpink')">BLACKPINK</a>
                                    <a href="javascript:;" name="_tags" data-value="nct" onclick="setTag('nct')">NCT</a>
                                    <a href="javascript:;" class="text-danger" onclick="clearTagFilter()">Clear Tags</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product List -->
                    <div class="col-lg-9 col-md-9 order-md-2 order-1">
                        <div class="row mb-5">
                            <div class="col-lg-6 col-md-8">
                                <div class="shop-toolbar__items shop-toolbar__item--left">
                                    <div class="shop-toolbar__item shop-toolbar__item--result">
                                        <p class="result-count">
                                            Showing <span id="products_count_start"></span>–<span id="products_count_end"></span> of <span id="products_count_total"></span>
                                        </p>
                                    </div>
                                    <div class="shop-toolbar__item">
                                        <select class="_filter form-select form-select-sm" name="_sort_by" onchange="getData(1)">
                                            <option value="name_asc">Sort by A-Z</option>
                                            <option value="name_desc">Sort by Z-A</option>
                                            <option value="latest_added">Sort by latest</option>
                                            <option value="price_asc">Sort by price: low to high</option>
                                            <option value="price_desc">Sort by price: high to low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-4">
                                <div class="header-right-search">
                                    <div class="header-search-box">
                                        <input class="_filter search-field" name="_search" type="text" onkeypress="getDataOnEnter(event)" placeholder="Search Album or Your Fave...">
                                        <button class="search-icon"><i class="icon-magnifier"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="row" id="product-list"></div>
                            <div class="row">
                                <div class="col-12">
                                    <ul class="page-pagination text-center mt-40" id="product-list-pagination"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Area End -->
    </div>
@endsection

@section('addition_css')
@endsection

@section('addition_script')
<script src="{{ asset('pages/js/plp.js') }}"></script>
@endsection