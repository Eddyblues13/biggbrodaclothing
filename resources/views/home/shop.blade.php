<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biggbroda Clothing</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-container">
            <div class="search-header">
                <h2 class="search-title">Search Products</h2>
                <button class="search-close" id="searchClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="search-input-container">
                <input type="text" class="search-input" id="searchInput" placeholder="What are you looking for?"
                    autocomplete="off">
                <button class="search-submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="search-suggestions">
                <div class="suggestion-category">
                    <h3>Popular Searches</h3>
                    <div class="suggestion-tags">
                        <span class="suggestion-tag">Hoodies</span>
                        <span class="suggestion-tag">Jerseys</span>
                        <span class="suggestion-tag">Shorts</span>
                        <span class="suggestion-tag">New Collection</span>
                        <span class="suggestion-tag">Sale Items</span>
                    </div>
                </div>
                <div class="suggestion-category">
                    <h3>Categories</h3>
                    <div class="suggestion-links">
                        <a href="#" class="suggestion-link">
                            <i class="fas fa-tshirt"></i>
                            <span>Clothing</span>
                        </a>
                        <a href="#" class="suggestion-link">
                            <i class="fas fa-running"></i>
                            <span>Sportswear</span>
                        </a>
                        <a href="#" class="suggestion-link">
                            <i class="fas fa-star"></i>
                            <span>New Arrivals</span>
                        </a>
                        <a href="#" class="suggestion-link">
                            <i class="fas fa-fire"></i>
                            <span>Trending</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Mobile Layout -->
            <div class="d-lg-none d-flex justify-content-between align-items-center w-100 mobile-navbar">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <div class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>

                <a class="navbar-brand" href="#">
                    <img src="img/logo.png" alt="logo" class="logo" width="150" height="50">
                </a>

                <div class="mobile-icons">
                    <a class="nav-link search-trigger" href="#"><i class="fas fa-search"></i></a>
                    <a class="nav-link" href="#"><i class="fas fa-shopping-bag"></i></a>
                </div>
            </div>

            <!-- Desktop Layout -->
            <div class="d-none d-lg-flex justify-content-between align-items-center w-100 desktop-navbar">
                <div class="navbar-nav nav-left">
                    <a class="nav-link" href="#">SHOP</a>
                    <a class="nav-link" href="#">ABOUT</a>
                    <a class="nav-link" href="#">OUR STORE</a>
                </div>

                <a class="navbar-brand mx-auto" href="#">
                    <img src="img/logo.png" alt="logo" class="logo" width="150" height="50">
                </a>

                <div class="navbar-nav nav-right">
                    <a class="nav-link search-trigger" href="#"><i class="fas fa-search"></i></a>
                    <a class="nav-link" href="#">NGN</a>
                    <a class="nav-link" href="#">LOGIN</a>
                    <a class="nav-link" href="#">WISHLIST</a>
                    <a class="nav-link" href="#"><i class="fas fa-shopping-bag"></i></a>
                </div>
            </div>

            <!-- Mobile Menu Collapse -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mobile-nav">
                    <li class="nav-item"><a class="nav-link" href="#">SHOP</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">ABOUT</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">OUR STORE</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">LOGIN</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">WISHLIST</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">NGN</a></li>
                </ul>
            </div>
        </div>
    </nav>

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
                        <span class="product-count" style="color: #cca264; font-weight: 600;">Showing 1-12 of 24
                            products</span>
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
                                        value="all" {{ request('category', 'all' )==='all' ? 'checked' : '' }}>
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

                            <button type="submit" class="btn btn-secondary w-100">APPLY</button>
                            <a href="" class="btn btn-outline-secondary w-100 mt-2">CLEAR
                                FILTERS</a>
                        </div>
                    </form>
                </div>

                {{-- Products Grid --}}
                <div class="col-lg-9">
                    <div class="sort-options mb-4 d-flex justify-content-between align-items-center">
                        <div class="view-options">
                            <button
                                class="btn btn-sm btn-outline-cca264 view-btn {{ request('view', 'grid') === 'grid' ? 'active' : '' }}"
                                data-view="grid"><i class="fas fa-th"></i></button>
                            <button
                                class="btn btn-sm btn-outline-cca264 view-btn {{ request('view') === 'list' ? 'active' : '' }}"
                                data-view="list"><i class="fas fa-list"></i></button>
                        </div>
                        <div class="sort-dropdown">
                            <select class="form-select" name="sort" form="filtersForm"
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
                            @foreach($products as $product)
                            <div class="col-lg-4 col-md-6 mb-4 product-item"
                                data-category="{{ $product->category->slug }}" data-price="{{ $product->price }}">
                                <div class="product-card {{ request('view', 'grid') === 'list' ? 'list-view' : '' }}">
                                    <div class="product-image position-relative">
                                        <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                            class="img-fluid">
                                        <div class="product-overlay">
                                            <a href="" class="btn btn-sm btn-outline-light"><i
                                                    class="fas fa-eye me-1"></i>Quick View</a>
                                            <button class="btn btn-sm btn-outline-light wishlist-btn"><i
                                                    class="fas fa-heart"></i></button>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-title">{{ $product->name }}</h3>
                                        <p class="product-price">
                                            ₦ {{ number_format($product->current_price, 2) }}
                                            @if($product->is_on_sale)
                                            <span class="text-muted text-decoration-line-through">₦ {{
                                                number_format($product->price,2) }}</span>
                                            <span class="badge bg-danger">-{{ $product->discount_percentage }}%</span>
                                            @endif
                                        </p>
                                        @if(!empty($product->available_sizes))
                                        <small class="text-secondary">Available in: {{ implode(', ',
                                            $product->available_sizes) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-5">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h3 class="footer-title">BIGGBRODA CLOTHING</h3>
                    <p>Premium streetwear and athletic apparel for the fashion-forward individual.</p>
                </div>
                <div class="col-md-2 mb-3">
                    <h3 class="footer-title">SHOP</h3>
                    <ul class="footer-links">
                        <li><a href="#">New Arrivals</a></li>
                        <li><a href="#">Best Sellers</a></li>
                        <li><a href="#">Collections</a></li>
                        <li><a href="#">Sale</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-3">
                    <h3 class="footer-title">HELP</h3>
                    <ul class="footer-links">
                        <li><a href="contact.html">Contact Us</a></li>
                        <li><a href="faq.html">FAQs</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Returns</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h3 class="footer-title">NEWSLETTER</h3>
                    <p>Subscribe to receive updates on new arrivals and special promotions.</p>
                    <form class="newsletter-form">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email">
                            <button class="btn btn-dark" type="submit">SUBSCRIBE</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <p>&copy; 2023 Biggbroda Clothing. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
    <script>
        // Shop functionality
        document.addEventListener('DOMContentLoaded', function() {
            const productItems = document.querySelectorAll('.product-item');
            const categoryFilters = document.querySelectorAll('.category-filter');
            const priceFilters = document.querySelectorAll('.price-filter');
            const sizeFilters = document.querySelectorAll('.size-filter');
            const clearFiltersBtn = document.getElementById('clearFilters');
            const sortSelect = document.getElementById('sortSelect');
            const viewBtns = document.querySelectorAll('.view-btn');
            const productsGrid = document.getElementById('productsGrid');

            // Category filtering
            categoryFilters.forEach(filter => {
                filter.addEventListener('change', function() {
                    if (this.checked) {
                        filterProducts();
                    }
                });
            });

            // Price filtering
            priceFilters.forEach(filter => {
                filter.addEventListener('change', filterProducts);
            });

            // Size filtering
            sizeFilters.forEach(filter => {
                filter.addEventListener('change', filterProducts);
            });

            // Clear filters
            clearFiltersBtn.addEventListener('click', function() {
                // Reset all filters
                document.querySelectorAll('.form-check-input').forEach(input => {
                    input.checked = false;
                });
                document.getElementById('all').checked = true;
                
                // Show all products
                productItems.forEach(item => {
                    item.style.display = 'block';
                });
                
                updateProductCount();
            });

            // Sort functionality
            sortSelect.addEventListener('change', function() {
                sortProducts(this.value);
            });

            // View toggle
            viewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const view = this.dataset.view;
                    
                    // Update active button
                    viewBtns.forEach(b => {
                        b.classList.remove('active');
                        b.style.borderColor = '#e0e0e0';
                        b.style.color = '#666';
                    });
                    
                    this.classList.add('active');
                    this.style.borderColor = '#cca264';
                    this.style.color = '#cca264';
                    
                    // Toggle view
                    if (view === 'list') {
                        productsGrid.classList.add('list-view');
                        productItems.forEach(item => {
                            item.classList.remove('col-lg-4', 'col-md-6');
                            item.classList.add('col-12');
                        });
                    } else {
                        productsGrid.classList.remove('list-view');
                        productItems.forEach(item => {
                            item.classList.remove('col-12');
                            item.classList.add('col-lg-4', 'col-md-6');
                        });
                    }
                });
            });

            // Wishlist functionality
            document.querySelectorAll('.wishlist-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.classList.toggle('active');
                    if (this.classList.contains('active')) {
                        this.style.background = '#cca264';
                        this.style.borderColor = '#cca264';
                        this.style.color = 'white';
                    } else {
                        this.style.background = 'transparent';
                        this.style.borderColor = 'white';
                        this.style.color = 'white';
                    }
                });
            });

            // Quick view functionality
            document.querySelectorAll('.quick-view-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.product;
                    // Here you would open a modal or redirect to product detail
                    window.location.href = 'product-detail.html';
                });
            });

            function filterProducts() {
                const selectedCategory = document.querySelector('.category-filter:checked').value;
                const selectedPrices = Array.from(document.querySelectorAll('.price-filter:checked')).map(cb => cb.value);
                const selectedSizes = Array.from(document.querySelectorAll('.size-filter:checked')).map(cb => cb.value);

                productItems.forEach(item => {
                    let showItem = true;

                    // Category filter
                    if (selectedCategory !== 'all' && item.dataset.category !== selectedCategory) {
                        showItem = false;
                    }

                    // Price filter
                    if (selectedPrices.length > 0) {
                        const itemPrice = parseInt(item.dataset.price);
                        let priceMatch = false;
                        
                        selectedPrices.forEach(priceRange => {
                            if (priceRange === '0-300000' && itemPrice < 300000) priceMatch = true;
                            if (priceRange === '300000-600000' && itemPrice >= 300000 && itemPrice <= 600000) priceMatch = true;
                            if (priceRange === '600000-1000000' && itemPrice >= 600000 && itemPrice <= 1000000) priceMatch = true;
                            if (priceRange === '1000000+' && itemPrice > 1000000) priceMatch = true;
                        });
                        
                        if (!priceMatch) showItem = false;
                    }

                    // Size filter (simplified - in real implementation, you'd check product availability)
                    if (selectedSizes.length > 0) {
                        // For demo purposes, assume all products have all sizes
                        // In real implementation, check against product data
                    }

                    item.style.display = showItem ? 'block' : 'none';
                });

                updateProductCount();
            }

            function sortProducts(sortBy) {
                const productsArray = Array.from(productItems);
                
                productsArray.sort((a, b) => {
                    switch (sortBy) {
                        case 'price-low':
                            return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                        case 'price-high':
                            return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                        case 'name':
                            return a.querySelector('.product-title').textContent.localeCompare(b.querySelector('.product-title').textContent);
                        case 'newest':
                            // For demo purposes, reverse order
                            return productsArray.indexOf(b) - productsArray.indexOf(a);
                        default:
                            return 0;
                    }
                });

                // Reorder DOM elements
                productsArray.forEach(item => {
                    productsGrid.appendChild(item);
                });
            }

            function updateProductCount() {
                const visibleProducts = document.querySelectorAll('.product-item[style*="block"], .product-item:not([style*="none"])').length;
                document.querySelector('.product-count').textContent = `Showing 1-${visibleProducts} of ${productItems.length} products`;
            }

            // Load more functionality
            document.getElementById('loadMoreBtn').addEventListener('click', function() {
                // In a real implementation, this would load more products via AJAX
                alert('Load more functionality would be implemented with your backend API');
            });

            // Product overlay effects
            document.querySelectorAll('.product-card').forEach(card => {
                const overlay = card.querySelector('.product-overlay');
                
                card.addEventListener('mouseenter', function() {
                    overlay.style.opacity = '1';
                });
                
                card.addEventListener('mouseleave', function() {
                    overlay.style.opacity = '0';
                });
            });

            // Initialize
            updateProductCount();
        });

        // Add custom styles for product overlays
        const style = document.createElement('style');
        style.textContent = `
            .product-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(16, 19, 32, 0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            
            .form-check-input:checked {
                background-color: #cca264;
                border-color: #cca264;
            }
            
            .form-check-input:focus {
                border-color: #cca264;
                box-shadow: 0 0 0 0.25rem rgba(204, 162, 100, 0.25);
            }
            
            .btn-check:checked + .btn {
                background-color: #cca264;
                border-color: #cca264;
                color: white;
            }
            
            .list-view .product-card {
                display: flex;
                align-items: center;
            }
            
            .list-view .product-image {
                width: 200px;
                flex-shrink: 0;
                margin-right: 1rem;
                margin-bottom: 0;
            }
            
            .list-view .product-info {
                flex-grow: 1;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>