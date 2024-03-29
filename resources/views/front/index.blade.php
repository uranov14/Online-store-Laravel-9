@extends('front.layout.layout')

@section('content')
<!-- Main-Slider -->
@if ($sliderBanners)
<div class="default-height ph-item">
    <div class="slider-main owl-carousel">
        @foreach($sliderBanners as $banner)
        <div class="bg-image">
            <div class="slide-content">
                <p>
                    <a @if(!empty($banner['link'])) 
                        href="{{ $banner['link'] }}" 
                        @else 
                        href="javascript:;" 
                        @endif
                    >
                        <img src="{{ asset('front/images/banner_images/' . $banner['image']) }}" alt="{{ $banner['alt'] }}">
                    </a>
                </p>
                {{-- <p>{{ $banner['title'] }}</p> --}}
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
<!-- Main-Slider /- -->
<!-- Banner-Layer -->
@if (isset($fixBanners[0]['image']))
<div class="banner-layer">
    <div class="container">
        <div class="image-banner">
            <a target="_blank" rel="nofollow" href="{{ url($fixBanners[0]['link']) }}" class="mx-auto banner-hover effect-dark-opacity">
                <img 
                    class="img-fluid" 
                    title="{{ $fixBanners[0]['title'] }}"
                    src="{{ asset('front/images/banner_images/'.$fixBanners[0]['image']) }}" 
                    alt="{{ $fixBanners[0]['alt'] }}"
                >
            </a>
            {{-- <div class="actor" style="display: flex; justify-content: center; align-items: center;">
                <span id="advertising">Here can be your advertising!</span>
            </div>
            <div class="actor"></div>
            <div class="actor"></div>
            <div class="actor"></div>
            <div class="actor">
                <a target="_blank" rel="nofollow" href="{{ url($fixBanners[0]['link']) }}" class="mx-auto banner-hover effect-dark-opacity">
                    <img 
                        class="img-fluid" 
                        title="{{ $fixBanners[0]['title'] }}"
                        src="{{ asset('front/images/banner_images/'.$fixBanners[0]['image']) }}" 
                        alt="{{ $fixBanners[0]['alt'] }}"
                    >
                </a>
            </div> --}}
        </div>
    </div>
</div>
@endif
<!-- Banner-Layer /- -->
<!-- Top Collection -->
<section class="section-maker">
    <div class="container">
        <div class="sec-maker-header text-center">
            <h3 class="sec-maker-h3">TOP COLLECTION</h3>
            <ul class="nav tab-nav-style-1-a justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#men-latest-products">New Arrivals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#men-best-selling-products">Best Sellers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#discounted-products">Discounted Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#men-featured-products">Featured Products</a>
                </li>
            </ul>
        </div>
        <div class="wrapper-content">
            <div class="outer-area-tab">
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="men-latest-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                @foreach ($newProducts as $product)
                                    @php
                                        $product_image_path = 'front/images/product_images/small/'.$product['product_image'];
                                    @endphp
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if (!empty($product['product_image']) && file_exists($product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="{{ $product['product_name'].'-image' }}"> 
                                                @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/medium/no-image.webp') }}" alt="No Image">  
                                                @endif
                                            </a>
                                            <div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>

                                            @php
                                                $getDiscountPrice = App\Models\Product::getDiscountPrice($product['id']);
                                            @endphp

                                            <div class="price-template">
                                            @if ($product['product_price'] > $getDiscountPrice)
                                                <div class="item-new-price">
                                                    {{ $getDiscountPrice }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                                <div class="item-old-price">
                                                    {{ $product['product_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                            @else
                                                <div class="item-new-price">
                                                    {{ $product['product_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="tag new">
                                            <span>NEW</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane show fade" id="men-best-selling-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                @foreach ($bestSellers as $product)
                                    @php
                                        $product_image_path = 'front/images/product_images/small/'.$product['product_image'];
                                    @endphp
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if (!empty($product['product_image']) && file_exists($product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="{{ $product['product_name'].'-image' }}"> 
                                                @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/medium/no-image.webp') }}" alt="No Image">  
                                                @endif
                                            </a>
                                            <div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>

                                            @php
                                                $getDiscountPrice = App\Models\Product::getDiscountPrice($product['id']);
                                            @endphp

                                            <div class="price-template">
                                            @if ($product['product_price'] > $getDiscountPrice)
                                                <div class="item-new-price">
                                                    {{ $getDiscountPrice }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                                <div class="item-old-price">
                                                    {{ $product['product_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                            @else
                                                <div class="item-new-price">
                                                    {{ $product['product_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                            @endif
                                            </div>
                                        </div>

                                        @if (in_array($product, $newProducts))
                                            <div class="tag new">
                                                <span>NEW</span>
                                            </div>    
                                        @endif
                                        
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="discounted-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                @foreach ($discountedProducts as $product)
                                    @php
                                        $product_image_path = 'front/images/product_images/small/'.$product['product_image'];
                                    @endphp
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if (!empty($product['product_image']) && file_exists($product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="{{ $product['product_name'].'-image' }}"> 
                                                @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/medium/no-image.webp') }}" alt="No Image">  
                                                @endif
                                            </a>
                                            <div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>

                                            @php
                                                $getDiscountPrice = App\Models\Product::getDiscountPrice($product['id']);
                                            @endphp

                                            <div class="price-template">
                                            @if ($product['product_price'] > $getDiscountPrice)
                                                <div class="item-new-price">
                                                    {{ $getDiscountPrice }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                                <div class="item-old-price">
                                                    {{ $product['product_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                            @else
                                                <div class="item-new-price">
                                                    {{ $product['product_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                        @if (in_array($product, $newProducts))
                                        <div class="tag new">
                                            <span>NEW</span>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="men-featured-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                @foreach ($featuredProducts as $product)
                                    @php
                                        $product_image_path = 'front/images/product_images/small/'.$product['product_image'];
                                    @endphp
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if (!empty($product['product_image']) && file_exists($product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="{{ $product['product_name'].'-image' }}"> 
                                                @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/medium/no-image.webp') }}" alt="No Image">  
                                                @endif
                                            </a>
                                            <div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>

                                            @php
                                                $getDiscountPrice = App\Models\Product::getDiscountPrice($product['id']);
                                            @endphp

                                            <div class="price-template">
                                            @if ($product['product_price'] > $getDiscountPrice)
                                                <div class="item-new-price">
                                                    {{ $getDiscountPrice }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                                <div class="item-old-price">
                                                    {{ $product['product_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                            @else
                                                <div class="item-new-price">
                                                    {{ $product['product_price'] }}&nbsp;<span style="font-size: .875rem; color:black;">&#x20b4;</span>
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                        @if (in_array($product, $newProducts))
                                        <div class="tag new">
                                            <span>NEW</span>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Top Collection /- -->
<!-- Banner-Layer -->
@if (isset($fixBanners[1]['image']))
<div class="banner-layer">
    <div class="container">
        <div class="image-banner">
            <a target="_blank" rel="nofollow" href="{{ url($fixBanners[1]['link']) }}" class="mx-auto banner-hover effect-dark-opacity">
                <img 
                    class="img-fluid" 
                    title="{{ $fixBanners[1]['title'] }}"
                    src="{{ asset('front/images/banner_images/'.$fixBanners[1]['image']) }}" 
                    alt="{{ $fixBanners[1]['alt'] }}"
                >
            </a>
        </div>
    </div>
</div>
@endif
<!-- Banner-Layer /- -->
<!-- Site-Priorities -->
<section class="app-priority">
    <div class="container">
        <div class="priority-wrapper u-s-p-b-80">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="single-item-wrapper">
                        <div class="single-item-icon">
                            <i class="ion ion-md-star"></i>
                        </div>
                        <h2>
                            Great Value
                        </h2>
                        <p>We offer competitive prices on our 100 million plus product range</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="single-item-wrapper">
                        <div class="single-item-icon">
                            <i class="ion ion-md-cash"></i>
                        </div>
                        <h2>
                            Shop with Confidence
                        </h2>
                        <p>Our Protection covers your purchase from click to delivery</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="single-item-wrapper">
                        <div class="single-item-icon">
                            <i class="ion ion-ios-card"></i>
                        </div>
                        <h2>
                            Safe Payment
                        </h2>
                        <p>Pay with the world’s most popular and secure payment methods</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="single-item-wrapper">
                        <div class="single-item-icon">
                            <i class="ion ion-md-contacts"></i>
                        </div>
                        <h2>
                            24/7 Help Center
                        </h2>
                        <p>Round-the-clock assistance for a smooth shopping experience</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Site-Priorities /- -->
@endsection