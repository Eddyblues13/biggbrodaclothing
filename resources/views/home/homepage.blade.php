@include("home.header")

<!-- Hero Carousel Section -->
<section class="hero-carousel">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('img/hero-img.jpg')">
                <div class="carousel-caption">
                    <button class="btn btn-outline-light">EXPLORE OUR NEW COLLECTION</button>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('img/hero-image.jpg')">
                <div class="carousel-caption">
                    <button class="btn btn-outline-light">SHOP NOW</button>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('img/img-3.jpg')">
                <div class="carousel-caption">
                    <button class="btn btn-outline-light">DISCOVER MORE</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- New In Section -->
<section class="new-in py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">NEW IN</h2>
            <a href="" class="explore-all">EXPLORE ALL</a>
        </div>
        <div class="row">
            @php
            $newProducts = App\Models\Product::active()
            ->newArrivals()
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
            @endphp

            @foreach($newProducts as $product)
            <div class="col-md-3 col-6 mb-4">
                <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                    <div class="product-card">
                        <div class="product-image position-relative">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="img-fluid">

                            @if($product->is_on_sale)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                -{{ $product->discount_percentage }}%
                            </span>
                            @endif
                        </div>
                        <div class="product-info mt-2">
                            <h3 class="product-title fs-6">{{ $product->name }}</h3>
                            <div class="d-flex align-items-center gap-2">
                                <p class="product-price mb-0 @if($product->is_on_sale) text-danger @endif">
                                    ₦ {{ number_format($product->current_price, 2) }}
                                </p>
                                @if($product->is_on_sale)
                                <p class="product-price text-muted mb-0 text-decoration-line-through">
                                    ₦ {{ number_format($product->price, 2) }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products py-5">
    <div class="container">
        <h2 class="section-title mb-4">FEATURED PRODUCTS</h2>
        <div class="row">
            <div class="col-md-3 col-6 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="img/product.jpg" alt="Red Shorts" class="img-fluid">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">BB LASGIDI SHORTS - RED</h3>
                        <p class="product-price">₦ 240,000.00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="img/product-2.jpg" alt="Orange Shorts" class="img-fluid">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">BB LASGIDI SHORTS - ORANGE</h3>
                        <p class="product-price">₦ 240,000.00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="img/product.jpg" alt="Red Jersey" class="img-fluid">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">BB LASGIDI JERSEY - RED</h3>
                        <p class="product-price">₦ 240,000.00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="img/product-2.jpg" alt="Orange Jersey" class="img-fluid">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">BB LASGIDI JERSEY - ORANGE</h3>
                        <p class="product-price">₦ 240,000.00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Collection Banner -->
<section class="collection-banner">
    <div class="container-fluid p-0">
        <div class="banner-content">
            <h2>THE NEW COLLECTION IS THE SYNTHESIS OF THE HARMONIOUS ELEMENTS OF PLAYFUL ELEGANCE</h2>
            <button class="btn btn-outline-light">EXPLORE OUR NEW COLLECTION</button>
        </div>
    </div>
</section>

