@include("home.header")

<!-- Right Side Cart Area -->
<div class="cart-bg-overlay"></div>
<div class="right-side-cart-area">
    <!-- Your cart content here -->
</div>

<!-- Breadcumb Area -->
<div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Collections</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shop Grid Area -->
<section class="shop_grid_area section-padding-80">
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="shop_sidebar_area">
                    <!-- Categories Widget -->
                    <div class="widget catagory mb-50">
                        <h6 class="widget-title mb-30">Categories</h6>
                        <div class="catagories-menu">
                            <ul id="menu-content2" class="menu-content collapse show">
                                @foreach ($categories as $index => $category)
                                <li data-toggle="collapse" data-target="#category-{{ $index }}"
                                    class="{{ $index === 0 ? '' : 'collapsed' }}">
                                    <a href="#" class="category-filter" data-category-id="{{ $category->id }}">
                                        {{ ucfirst($category->name) }}
                                    </a>
                                    <ul class="sub-menu collapse {{ $index === 0 ? 'show' : '' }}"
                                        id="category-{{ $index }}">
                                        <li><a href="#" class="category-filter"
                                                data-category-id="{{ $category->id }}">All</a></li>
                                        @foreach ($category->products->take(10) as $product)
                                        <li><a href="{{ route('product.show', $product->slug) }}">{{ $product->name
                                                }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Price Widget -->
                    <div class="widget price mb-50">
                        <h6 class="widget-title mb-30">Filter by</h6>
                        <p class="widget-title2 mb-30">Price</p>
                        <div class="widget-desc">
                            <div class="slider-range">
                                <div id="price-range-slider" data-min="{{ $minPrice }}" data-max="{{ $maxPrice }}"
                                    data-unit="$" class="slider-range-price"></div>
                                <div class="range-price">
                                    Range: $<span id="min-price-value">{{ number_format($minPrice, 2) }}</span> -
                                    $<span id="max-price-value">{{ number_format($maxPrice, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Color Widget -->
                    <div class="widget color mb-50">
                        <p class="widget-title2 mb-30">Color</p>
                        <div class="widget-desc">
                            <ul class="d-flex flex-wrap">
                                @foreach ($colors as $color)
                                <li>
                                    <a href="#" class="color-filter" data-color="{{ strtolower($color) }}"
                                        style="background-color: {{ strtolower($color) }};"
                                        title="{{ ucfirst($color) }}"></a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Brand Widget -->
                    <div class="widget brands mb-50">
                        <p class="widget-title2 mb-30">Brands</p>
                        <div class="widget-desc">
                            <ul>
                                @foreach($brands as $brand)
                                <li>
                                    <a href="#" class="brand-filter" data-brand="{{ $brand }}">
                                        {{ $brand }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <button id="clear-filters" class="btn essence-btn btn-sm">Clear All Filters</button>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-12 col-md-8 col-lg-9">
                <div class="shop_grid_product_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="product-topbar d-flex align-items-center justify-content-between">
                                <div class="total-products">
                                    <p><span id="productCount">{{ $products->total() }}</span> products found</p>
                                </div>
                                <div class="product-sorting d-flex">
                                    <p>Sort by:</p>
                                    <select id="sortSelect" class="form-control">
                                        <option value="newest">Newest</option>
                                        <option value="price_asc">Price: Low to High</option>
                                        <option value="price_desc">Price: High to Low</option>
                                        <option value="bestsellers">Bestsellers</option>
                                        <option value="featured">Featured</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="productsContainer">
                        @foreach($products as $product)
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-product-wrapper">
                                <div class="product-img">
                                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}">
                                    @if($product->gallery_urls)
                                    <img class="hover-img" src="{{ $product->gallery_urls[0] ?? $product->image_url }}"
                                        alt="">
                                    @endif

                                    @if($product->is_on_sale)
                                    <div class="product-badge offer-badge">
                                        <span>-{{ $product->discount_percentage }}%</span>
                                    </div>
                                    @endif

                                    @if($product->is_new)
                                    <div class="product-badge new-badge">
                                        <span>New</span>
                                    </div>
                                    @endif

                                    <div class="product-favourite">
                                        <a href="#" class="favme fa fa-heart"></a>
                                    </div>
                                </div>

                                <div class="product-description">
                                    <span>{{ $product->brand }}</span>
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <h6>{{ $product->name }}</h6>
                                    </a>
                                    <p class="product-price">
                                        @if($product->is_on_sale)
                                        <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                        ${{ number_format($product->current_price, 2) }}
                                    </p>

                                    <div class="hover-content">
                                        <div class="add-to-cart-btn">
                                            <a href="#" class="btn essence-btn add-to-cart"
                                                data-product-id="{{ $product->id }}">Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <nav aria-label="navigation">
                        <div id="paginationLinks">
                            {{ $products->links() }}
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

@include("home.footer")

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/nouislider@15.5.1/dist/nouislider.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.5.1/dist/nouislider.min.css">
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const filters = {
        category: null,
        minPrice: {{ $minPrice }},
        maxPrice: {{ $maxPrice }},
        colors: [],
        brands: [],
        sort: 'newest',
        page: 1
    };

    // Initialize price slider
    const priceSlider = document.getElementById('price-range-slider');
    if (priceSlider) {
        noUiSlider.create(priceSlider, {
            start: [filters.minPrice, filters.maxPrice],
            connect: true,
            range: {
                'min': parseInt(priceSlider.dataset.min),
                'max': parseInt(priceSlider.dataset.max)
            },
            step: 1
        });

        priceSlider.noUiSlider.on('update', function(values, handle) {
            const value = Math.round(values[handle]);
            if (handle) {
                document.getElementById('max-price-value').textContent = value.toFixed(2);
                filters.maxPrice = value;
            } else {
                document.getElementById('min-price-value').textContent = value.toFixed(2);
                filters.minPrice = value;
            }
            applyFilters();
        });
    }

    // Category filter
    document.querySelectorAll('.category-filter').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            filters.category = this.dataset.categoryId;
            document.querySelectorAll('.category-filter').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
            applyFilters();
        });
    });

    // Color filter
    document.querySelectorAll('.color-filter').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const color = this.dataset.color;
            const index = filters.colors.indexOf(color);
            
            if (index > -1) {
                filters.colors.splice(index, 1);
                this.classList.remove('active');
            } else {
                filters.colors.push(color);
                this.classList.add('active');
            }
            applyFilters();
        });
    });

    // Brand filter
    document.querySelectorAll('.brand-filter').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const brand = this.dataset.brand;
            const index = filters.brands.indexOf(brand);
            
            if (index > -1) {
                filters.brands.splice(index, 1);
                this.classList.remove('active');
            } else {
                filters.brands.push(brand);
                this.classList.add('active');
            }
            applyFilters();
        });
    });

    // Sort select
    document.getElementById('sortSelect').addEventListener('change', function(e) {
        filters.sort = e.target.value;
        applyFilters();
    });

    // Clear all filters
    document.getElementById('clear-filters').addEventListener('click', function() {
        filters.category = null;
        filters.minPrice = {{ $minPrice }};
        filters.maxPrice = {{ $maxPrice }};
        filters.colors = [];
        filters.brands = [];
        filters.sort = 'newest';
        
        priceSlider.noUiSlider.set([filters.minPrice, filters.maxPrice]);
        document.getElementById('sortSelect').value = 'newest';
        document.querySelectorAll('.category-filter, .color-filter, .brand-filter').forEach(el => {
            el.classList.remove('active');
        });
        
        applyFilters();
    });

    // Handle pagination clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = new URL(e.target.href);
            filters.page = url.searchParams.get('page');
            applyFilters();
        }
    });

    // Main filter function
    function applyFilters() {
        const productsContainer = document.getElementById('productsContainer');
        productsContainer.innerHTML = '<div class="text-center py-5">Loading products...</div>';
        
        const params = new URLSearchParams();
        
        if (filters.category) params.append('category', filters.category);
        if (filters.minPrice) params.append('min_price', filters.minPrice);
        if (filters.maxPrice) params.append('max_price', filters.maxPrice);
        filters.colors.forEach(color => params.append('colors[]', color));
        filters.brands.forEach(brand => params.append('brands[]', brand));
        params.append('sort', filters.sort);
        params.append('page', filters.page);
        
        fetch(`/products/filter?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            document.getElementById('productsContainer').innerHTML = data.html;
            document.getElementById('productCount').textContent = data.count;
            document.getElementById('paginationLinks').innerHTML = data.pagination;
            
            window.scrollTo({
                top: document.getElementById('productsContainer').offsetTop - 100,
                behavior: 'smooth'
            });
        })
        .catch(error => {
            console.error('Error:', error);
            productsContainer.innerHTML = `
                <div class="text-center py-5 text-danger">
                    Error loading products<br>
                    <small>${error.message}</small>
                </div>
            `;
        });
    }
});
</script>
@endpush