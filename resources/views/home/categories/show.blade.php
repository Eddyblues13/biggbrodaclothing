@include("home.header")

<!-- New In Section -->
<section class="new-in py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">NEW IN</h2>
            <a href="" class="explore-all">EXPLORE ALL</a>
        </div>
        <div class="row">
            @php
            $newProducts = \App\Models\Product::active()
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