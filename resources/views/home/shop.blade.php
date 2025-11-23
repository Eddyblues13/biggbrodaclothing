@include("home.header")

<!-- Shop Header -->
<section class="shop-header py-5" style="margin-top: 100px; background: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="section-title mb-3">SHOP COLLECTION</h1>
                <p style="color: #666;">Discover our premium streetwear and athletic apparel collection</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="shop-stats">
                    <span class="product-count" style="color: #cca264; font-weight: 600;">
                        Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Shop Content -->
<section class="shop-content py-5">
    <div class="container">
        <div class="row">
            {{-- Sidebar Filters --}}
            <div class="col-lg-3 mb-4">
                <form method="GET" id="filtersForm">
                    <div class="filters-sidebar bg-white rounded p-4 position-sticky"
                        style="top:120px; box-shadow: 0 4px 20px rgba(16,19,32,0.08);">
                        <h5 class="mb-4 fw-semibold">FILTERS</h5>

                        {{-- Category --}}
                        <div class="filter-group mb-4">
                            <h6 class="filter-title text-uppercase fw-medium mb-3">Category</h6>
                            @foreach($categories as $cat)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="category"
                                    id="cat_{{ $cat->slug }}" value="{{ $cat->slug }}" {{
                                    request('category')===$cat->slug ? 'checked' : '' }}>
                                <label class="form-check-label text-secondary" for="cat_{{ $cat->slug }}">{{
                                    $cat->name }}</label>
                            </div>
                            @endforeach
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="category" id="cat_all"
                                    value="" {{ !request('category') ? 'checked' : '' }}>
                                <label class="form-check-label text-secondary" for="cat_all">All Products</label>
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="filter-group mb-4">
                            <h6 class="filter-title text-uppercase fw-medium mb-3">Price Range</h6>
                            @php
                            $priceRanges = [
                            '0-300000' => 'Under ₦300,000',
                            '300000-600000' => '₦300,000 - ₦600,000',
                            '600000-1000000' => '₦600,000 - ₦1,000,000',
                            '1000000+' => 'Over ₦1,000,000',
                            ];
                            @endphp
                            @foreach($priceRanges as $value => $label)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="price[]"
                                    id="price_{{ $value }}" value="{{ $value }}" {{ in_array($value,
                                    (array)request('price', [])) ? 'checked' : '' }}>
                                <label class="form-check-label text-secondary" for="price_{{ $value }}">{{ $label
                                    }}</label>
                            </div>
                            @endforeach
                        </div>

                        {{-- Size --}}
                        <div class="filter-group mb-4">
                            <h6 class="filter-title text-uppercase fw-medium mb-3">Size</h6>
                            <div class="size-filters d-flex flex-wrap gap-2">
                                @foreach($sizes as $size)
                                <input type="checkbox" class="btn-check" name="size[]" id="size-{{ $size }}"
                                    value="{{ $size }}" {{ in_array($size, (array)request('size', [])) ? 'checked'
                                    : '' }}>
                                <label class="btn btn-outline-secondary btn-sm border-cca264 text-dark"
                                    for="size-{{ $size }}">{{ $size }}</label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100">APPLY FILTERS</button>
                        <a href="{{ route('shop') }}" class="btn btn-outline-dark w-100 mt-2">CLEAR FILTERS</a>
                    </div>
                </form>
            </div>

            {{-- Products Grid --}}
            <div class="col-lg-9">
                <div class="sort-options mb-4 d-flex justify-content-between align-items-center">
                    <div class="view-options">
                        <button
                            class="btn btn-sm btn-outline-dark view-btn {{ request('view', 'grid') === 'grid' ? 'active' : '' }}"
                            data-view="grid"><i class="fas fa-th"></i></button>
                        <button
                            class="btn btn-sm btn-outline-dark view-btn {{ request('view') === 'list' ? 'active' : '' }}"
                            data-view="list"><i class="fas fa-list"></i></button>
                    </div>
                    <div class="sort-dropdown">
                        <select class="form-select" name="sort" id="sortSelect"
                            style="width:auto; border-color:#cca264;">
                            @foreach(['featured'=>'Featured','price-low'=>'Price: Low to High','price-high'=>'Price:
                            High to Low','newest'=>'Newest First','name'=>'Name: A to Z'] as $key=>$label)
                            <option value="{{ $key }}" {{ request('sort')===$key ? 'selected' : '' }}>Sort by: {{
                                $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="products-container">
                    <div class="row" id="productsGrid">
                        @forelse($products as $product)
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6 mb-4 product-item"
                            data-category="{{ $product->category->slug }}" data-price="{{ $product->price }}">
                            <div class="product-card h-100 d-flex flex-column">
                                <div class="product-image position-relative flex-grow-0">
                                    <img src="{{ $product->thumbnail_url ?? $product->image_url }}" alt="{{ $product->name }}"
                                        class="img-fluid w-100 product-img">
                                    <div class="product-overlay d-flex align-items-center justify-content-center">
                                        <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-outline-light me-1 mb-1">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        <button class="btn btn-sm btn-outline-light add-to-cart-btn mb-1" 
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-product-price="{{ $product->current_price }}"
                                                data-product-image="{{ $product->thumbnail_url ?? $product->image_url }}"
                                                data-product-slug="{{ $product->slug }}">
                                            <i class="fas fa-shopping-cart me-1"></i>Cart
                                        </button>
                                    </div>
                                    @if($product->is_on_sale)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                    @endif
                                </div>
                                <div class="product-info p-2 flex-grow-1 d-flex flex-column">
                                    <h3 class="product-title h6 mb-1 flex-grow-0">{{ Str::limit($product->name, 50) }}</h3>
                                    <div class="mt-auto">
                                        <p class="product-price mb-1">
                                            <span class="fw-bold @if($product->is_on_sale) text-danger @endif">
                                                ₦ {{ number_format($product->current_price, 2) }}
                                            </span>
                                            @if($product->is_on_sale)
                                            <span class="text-muted text-decoration-line-through ms-1 small">₦ {{
                                                number_format($product->price,2) }}</span>
                                            @endif
                                        </p>
                                        @if(!empty($product->available_sizes))
                                        <small class="text-secondary d-block">Sizes: {{ implode(', ',
                                            array_slice($product->available_sizes, 0, 3)) }}{{ count($product->available_sizes) > 3 ? '...' : '' }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No products found</h4>
                            <p class="text-muted">Try adjusting your filters or search terms</p>
                            <a href="{{ route('shop') }}" class="btn btn-dark">Clear Filters</a>
                        </div>
                        @endforelse
                    </div>

                    @if($products->hasPages())
                    <div class="text-center mt-5">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .product-image {
        position: relative;
        overflow: hidden;
    }

    .product-img {
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.05);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        padding: 10px;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .product-overlay .btn {
        transform: translateY(20px);
        transition: transform 0.3s ease;
        font-size: 0.8rem;
        padding: 5px 10px;
        margin: 2px;
    }

    .product-card:hover .product-overlay .btn {
        transform: translateY(0);
    }

    .view-btn.active {
        background-color: #000;
        color: #fff;
        border-color: #000;
    }

    .btn-check:checked + .btn {
        background-color: #cca264;
        border-color: #cca264;
        color: #fff;
    }

    .product-info {
        background: white;
    }

    /* List view styles */
    .product-card.list-view {
        flex-direction: row !important;
    }

    .product-card.list-view .product-image {
        width: 200px;
        flex-shrink: 0;
    }

    .product-card.list-view .product-img {
        height: 200px;
    }

    .product-card.list-view .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 1rem !important;
    }

    /* Mobile Responsive */
    @media (max-width: 576px) {
        .shop-header {
            margin-top: 80px !important;
            padding: 2rem 0 !important;
        }
        
        .shop-header h1 {
            font-size: 1.5rem;
        }
        
        .product-img {
            height: 180px;
        }
        
        .product-overlay .btn {
            font-size: 0.7rem;
            padding: 4px 8px;
        }
        
        .product-title {
            font-size: 0.9rem;
        }
        
        .product-price {
            font-size: 0.9rem;
        }
        
        .filters-sidebar {
            position: relative !important;
            top: 0 !important;
            margin-bottom: 1rem;
        }
        
        .sort-options {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
        
        .view-options {
            margin-bottom: 10px;
        }
    }

    @media (max-width: 768px) {
        .product-card.list-view {
            flex-direction: column !important;
        }
        
        .product-card.list-view .product-image {
            width: 100%;
        }
        
        .col-lg-3 {
            margin-bottom: 2rem;
        }
    }

    @media (min-width: 576px) and (max-width: 768px) {
        .col-sm-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media (min-width: 768px) and (max-width: 992px) {
        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
    }

    /* Ensure 3 columns on all screens */
    @media (min-width: 576px) {
        .col-sm-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media (min-width: 768px) {
        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
    }

    @media (min-width: 992px) {
        .col-lg-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
    }

    @media (min-width: 1200px) {
        .col-xl-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // View toggle functionality
        const viewButtons = document.querySelectorAll('.view-btn');
        const productCards = document.querySelectorAll('.product-card');
        
        viewButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const viewType = this.getAttribute('data-view');
                
                // Update URL parameter
                const url = new URL(window.location);
                url.searchParams.set('view', viewType);
                window.history.replaceState({}, '', url);
                
                // Toggle active class
                viewButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Toggle list view class
                productCards.forEach(card => {
                    if (viewType === 'list') {
                        card.classList.add('list-view');
                    } else {
                        card.classList.remove('list-view');
                    }
                });
            });
        });

        // Sort select change handler
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                document.getElementById('filtersForm').submit();
            });
        }

        // Add to cart functionality
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                
                // Show loading state
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>';
                this.disabled = true;
                
                // Make API call to add to cart
                axios.post('{{ route("cart.add") }}', {
                    product_id: productId,
                    quantity: 1,
                    _token: '{{ csrf_token() }}'
                })
                .then(response => {
                    if (response.data.success) {
                        // Show success message
                        toastr.success(productName + ' added to cart!');
                        
                        // Update cart count in navigation
                        document.querySelectorAll('.cart-count').forEach(el => {
                            el.textContent = response.data.cart_count;
                            el.style.display = response.data.cart_count > 0 ? 'inline-block' : 'none';
                        });
                    } else {
                        toastr.error(response.data.message || 'Failed to add product to cart');
                    }
                })
                .catch(error => {
                    console.error('Add to cart error:', error);
                    toastr.error(error.response?.data?.message || 'Failed to add product to cart');
                })
                .finally(() => {
                    // Reset button state
                    this.innerHTML = originalHtml;
                    this.disabled = false;
                });
            });
        });

        // Auto-submit form when filters change (optional)
        const filterInputs = document.querySelectorAll('#filtersForm input[type="radio"], #filtersForm input[type="checkbox"]');
        let filterTimeout;
        
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Debounce the form submission to avoid too many requests
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(() => {
                    document.getElementById('filtersForm').submit();
                }, 500);
            });
        });
    });

    // Initialize Toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000"
    };
</script>

@include("home.footer")