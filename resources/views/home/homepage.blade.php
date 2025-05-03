@include("home.header")
<!-- ##### Right Side Cart End ##### -->

<!-- ##### Welcome Area Start ##### -->
<section class="welcome_area bg-img background-overlay"
    style="background-image: url('{{ asset('assets/img/bg-img/bg-1.jpg') }}');">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="hero-content">
                    <h6>asoss</h6>
                    <h2>Shop with us</h2>
                    <a href="{{route('collections')}}" class="btn essence-btn">view collection</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Welcome Area End ##### -->

<!-- ##### Top Catagory Area Start ##### -->
<div class="top_catagory_area section-padding-80 clearfix">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($categories as $category)
            <!-- Single Catagory -->
            <div class="col-12 col-sm-6 col-md-4">
                <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                    style="background-image: url({{ asset('img/bg-img/bg-' . $loop->iteration + 1 . '.jpg') }});">
                    <div class="catagory-content">
                        <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- ##### Top Catagory Area End ##### -->

<!-- ##### CTA Area Start ##### -->
<div class="cta-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cta-content bg-img background-overlay"
                    style="background-image: url('{{ asset('assets/img/bg-img/bg-5.jpg') }}');">
                    <div class="h-100 d-flex align-items-center justify-content-end">
                        <div class="cta--text">
                            <h6>-60%</h6>
                            <h2>Global Sale</h2>
                            <a href="#" class="btn essence-btn">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### CTA Area End ##### -->

<!-- ##### New Arrivals Area Start ##### -->
<section class="new_arrivals_area section-padding-80 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center">
                    <h2>Popular Products</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="popular-products-slides owl-carousel">
                    @foreach($popularProducts as $product)

                    <!-- Single Product -->
                    <div class="single-product-wrapper">
                        <!-- Product Image -->
                        <a href="{{ route('products.show', $product->slug) }}">
                            <div class="product-img">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                <!-- Hover Thumb -->
                                @if(count($product->gallery_urls) > 0)
                                <img class="hover-img" src="{{ $product->gallery_urls[0] }}" alt="{{ $product->name }}">
                                @endif

                                <!-- Product Badge -->
                                @if($product->is_new)
                                <div class="product-badge new-badge">
                                    <span>New</span>
                                </div>
                                @endif

                                @if($product->isOnSale)
                                <div class="product-badge offer-badge">
                                    <span>-{{ $product->discount_percentage }}%</span>
                                </div>
                                @endif

                                <!-- Favourite -->
                                <div class="product-favourite">
                                    <a href="#"
                                        class="favme fa fa-heart {{ in_array($product->id, $favorites) ? 'active' : '' }}"
                                        data-product-id="{{ $product->id }}"></a>
                                </div>
                            </div>
                        </a>
                        <!-- Product Description -->
                        <div class="product-description">
                            <span>{{ $product->brand }}</span>
                            <a href="{{ route('products.show', $product->slug) }}">
                                <h6>{{ $product->name }}</h6>
                            </a>

                            @if($product->isOnSale)
                            <p class="product-price">
                                <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                ${{ number_format($product->discount_price, 2) }}
                            </p>
                            @else
                            <p class="product-price">${{ number_format($product->price, 2) }}</p>
                            @endif

                            <!-- Hover Content -->
                            <div class="hover-content">
                                <!-- Add to Cart -->
                                <div class="add-to-cart-btn">
                                    <a href="#" class="btn essence-btn add-to-cart"
                                        data-product-id="{{ $product->id }}">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### New Arrivals Area End ##### -->

<!-- ##### Brands Area Start ##### -->
<div class="brands-area d-flex align-items-center justify-content-between">
    <!-- Brand Logo -->
    <div class="single-brands-logo">
        <img src="{{ asset('assets/img/core-img/brand1.png') }}" alt="">
    </div>
    <!-- Brand Logo -->
    <div class="single-brands-logo">
        <img src="{{ asset('assets/img/core-img/brand2.png') }}" alt="">
    </div>
    <!-- Brand Logo -->
    <div class="single-brands-logo">
        <img src="{{ asset('assets/img/core-img/brand3.png') }}" alt="">
    </div>
    <!-- Brand Logo -->
    <div class="single-brands-logo">
        <img src="{{ asset('assets/img/core-img/brand4.png') }}" alt="">
    </div>
    <!-- Brand Logo -->
    <div class="single-brands-logo">
        <img src="{{ asset('assets/img/core-img/brand5.png') }}" alt="">
    </div>
    <!-- Brand Logo -->
    <div class="single-brands-logo">
        <img src="{{ asset('assets/img/core-img/brand6.png') }}" alt="">
    </div>
</div>
<!-- ##### Brands Area End ##### -->

@include("home.footer")