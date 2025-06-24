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



<!-- Categories Section -->
<section class="categories-section py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">SHOP BY CATEGORY</h2>
            <a href="{{ route('categories.index') }}" class="explore-all">VIEW ALL</a>
        </div>
        <div class="categories-container">
            <div class="categories-scroll">
                @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="category-card">
                    <div class="category-image">
                        @php
                        $product = $category->products->first();
                        $galleryImage = $product && $product->galleries->isNotEmpty()
                        ? $product->galleries->first()->image_url
                        : ($product->image_url ?? asset('images/default-category.jpg'));
                        @endphp

                        <img src="{{ $galleryImage }}" alt="{{ $category->name }}" class="img-fluid">

                        <div class="category-overlay">
                            <h3 class="category-name">{{ strtoupper($category->name) }}</h3>
                            <span class="category-count">
                                {{ $category->products_count }}
                                {{ $category->products_count == 1 ? 'Item' : 'Items' }}
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>


<!-- Featured Products -->
<section class="featured-products py-5">
    <div class="container">
        <h2 class="section-title mb-4">FEATURED PRODUCTS</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-md-3 col-6 mb-4">
                <a href="{{ route('product.show', $product) }}" class="product-card text-decoration-none text-dark">
                    <div class="product-image position-relative">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid">
                        @if($product->is_on_sale)
                        <span class="badge bg-danger position-absolute top-0 start-0 mt-2 ms-2">
                            SALE
                        </span>
                        @endif
                    </div>
                    <div class="product-info mt-2">
                        <h3 class="product-title h6 mb-1">{{ $product->name }}</h3>
                        <div class="d-flex align-items-center">
                            @if($product->is_on_sale)
                            <p class="product-price text-danger mb-0 me-2">
                                ₦ {{ number_format($product->current_price, 2) }}
                            </p>
                            <p class="product-price text-muted mb-0 text-decoration-line-through">
                                ₦ {{ number_format($product->price, 2) }}
                            </p>
                            @else
                            <p class="product-price mb-0">
                                ₦ {{ number_format($product->price, 2) }}
                            </p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
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