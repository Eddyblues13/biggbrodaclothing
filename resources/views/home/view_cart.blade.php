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
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>

<body>
    <!-- Search Overlay (same as before) -->

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
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-bag fs-5"></i>
                        <span id="cartMobileBadge"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count"
                            style="font-size: 0.65em; min-width: 20px; padding: 3px 5px; {{ $cartCount > 0 ? '' : 'display: none;' }}">
                            {{ $cartCount > 0 ? $cartCount : '' }}
                        </span>
                    </a>
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
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-bag fs-5"></i>
                        <span id="cartBadge"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count"
                            style="font-size: 0.65em; min-width: 20px; padding: 3px 5px; {{ $cartCount > 0 ? '' : 'display: none;' }}">
                            {{ $cartCount > 0 ? $cartCount : '' }}
                        </span>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Collapse (same as before) -->
        </div>
    </nav>

    <!-- Cart Section -->
    <section class="cart-section py-5" style="margin-top: 100px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="section-title mb-4">SHOPPING CART</h1>
                    @if($cartCount > 0)
                    <div class="d-flex justify-content-end">
                        <span class="cart-count-badge">{{ $cartCount }} {{ $cartCount > 1 ? 'items' : 'item' }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="cart-items">
                        @if($cartCount > 0)
                        @foreach($cart as $key => $item)
                        <div class="cart-item" data-cart-key="{{ $key }}">
                            <div class="row align-items-center">
                                <div class="col-md-2 col-4 mb-3 mb-md-0">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid rounded"
                                        style="max-height: 120px;">
                                </div>
                                <div class="col-md-4 col-8 mb-3 mb-md-0">
                                    <h5 class="product-title mb-2">{{ $item['name'] }}</h5>

                                    @if(isset($item['size']) && $item['size'])
                                    <p class="text-muted mb-1">Size: {{ $item['size'] }}</p>
                                    @endif

                                    @if(isset($item['color']) && $item['color'])
                                    <p class="text-muted mb-0">Color: {{ $item['color'] }}</p>
                                    @endif

                                    @if(isset($item['delivery_date']))
                                    <p class="delivery-badge mt-2 mb-0">
                                        <i class="fas fa-truck me-1"></i> Delivery by {{ $item['delivery_date'] }}
                                    </p>
                                    @endif
                                </div>

                                <div class="col-md-2 col-4 mb-3 mb-md-0">
                                    <div class="quantity-controls">
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                                onclick="updateCartItem('{{ $key }}', -1)">
                                                -
                                            </button>
                                            <input type="text"
                                                class="form-control form-control-sm text-center quantity-input"
                                                value="{{ $item['quantity'] }}" readonly>
                                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                                onclick="updateCartItem('{{ $key }}', 1)">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-4 mb-3 mb-md-0">
                                    <p class="product-price mb-0">
                                        <span class="fw-bold">₦ {{ number_format($item['price'] * $item['quantity'], 2)
                                            }}</span>
                                    </p>
                                    <div class="text-muted small">
                                        ₦ {{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}
                                    </div>
                                </div>

                                <div class="col-md-1 col-4">
                                    <button class="btn btn-link text-danger p-0" onclick="removeCartItem('{{ $key }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="cart-item text-center">
                            <div class="py-5">
                                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                                <h4 class="mb-3">Your cart is empty</h4>
                                <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet</p>
                                <a href="" class="btn btn-dark px-5">
                                    <i class="fas fa-shopping-bag me-2"></i> Start Shopping
                                </a>
                            </div>
                        </div>
                        @endif


                        @if($cartCount > 0)
                        <!-- Continue Shopping -->
                        <div class="continue-shopping mt-4">
                            <a href="" class="btn btn-continue">
                                <i class="fas fa-arrow-left me-2"></i>CONTINUE SHOPPING
                            </a>
                            <button class="btn btn-danger ms-2" onclick="clearCart()">
                                <i class="fas fa-trash-alt me-2"></i> CLEAR CART
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                @if($cartCount > 0)
                <!-- Cart Summary -->
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>₦{{ number_format($subtotal, 2) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Shipping:</span>
                            <span>₦{{ number_format($shipping, 2) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Tax (5%):</span>
                            <span>₦{{ number_format($tax, 2) }}</span>
                        </div>

                        <div class="summary-row total">
                            <span>Total:</span>
                            <span>₦{{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            @if($cartCount > 0 && !empty($relatedProducts))

            <div class="row mt-5">
                <div class="col-12">
                    <h4 class="section-title mb-4">FREQUENTLY BOUGHT TOGETHER</h4>
                    <div class="row">
                        @foreach($relatedProducts as $product)
                        <div class="col-md-3 col-6 mb-4">
                            <div class="product-card">
                                <div class="position-relative">
                                    @if($product->is_on_sale)
                                    <span class="discount-badge">
                                        {{ $product->discount_percentage }}% OFF
                                    </span>
                                    @endif
                                    <img src="{{ $product->image_url }}" class="product-image"
                                        alt="{{ $product->name }}">
                                </div>
                                <div class="product-info">
                                    <h6 class="product-card-title">{{ $product->name }}</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="product-card-price">₦ {{ number_format($product->current_price, 2)
                                            }}</span>
                                        @if($product->is_on_sale)
                                        <span class="original-price">₦ {{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0 pt-0">
                                    <button class="btn btn-sm btn-outline-dark w-100"
                                        onclick="addToCart({{ $product->id }})">
                                        <i class="fas fa-plus me-1"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
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
                    <ul class="footer-links list-unstyled">
                        <li><a href="#">New Arrivals</a></li>
                        <li><a href="#">Best Sellers</a></li>
                        <li><a href="#">Collections</a></li>
                        <li><a href="#">Sale</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-3">
                    <h3 class="footer-title">HELP</h3>
                    <ul class="footer-links list-unstyled">
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQs</a></li>
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
                    <p>&copy; {{ date('Y') }} Biggbroda Clothing. All rights reserved.</p>
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Initialize Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000"
        };

        // Update cart item quantity
        function updateCartItem(cartKey, change) {
            axios.post('{{ route("cart.update") }}', {
                cart_key: cartKey,
                change: change,
                _token: '{{ csrf_token() }}'
            })
            .then(response => {
                if (response.data.success) {
                    toastr.success(response.data.message);
                    
                    // Update cart count in navigation
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = response.data.cart_count;
                        el.style.display = response.data.cart_count > 0 ? 'inline-block' : 'none';
                    });
                    
                    // Update cart count badge
                    document.querySelector('.cart-count-badge').textContent = 
                        response.data.cart_count + (response.data.cart_count === 1 ? ' item' : ' items');
                    
                    // If item was removed, remove the row
                    if (response.data.item_removed) {
                        document.querySelector(`.cart-item[data-cart-key="${cartKey}"]`).remove();
                        
                        // If cart is empty, reload page to show empty cart message
                        if (response.data.cart_count === 0) {
                            setTimeout(() => location.reload(), 1000);
                        }
                    } else {
                        // Update the quantity input
                        const input = document.querySelector(`.cart-item[data-cart-key="${cartKey}"] .quantity-input`);
                        input.value = parseInt(input.value) + change;
                        
                        // Update subtotal for this row
                        const price = parseFloat(response.data.item_price);
                        const quantity = parseInt(input.value);
                        const subtotalCell = document.querySelector(`.cart-item[data-cart-key="${cartKey}"] .product-price .fw-bold`);
                        subtotalCell.textContent = '₦ ' + (price * quantity).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    }
                    
                    // Update order summary
                    updateOrderSummary(response.data);
                } else {
                    toastr.warning(response.data.message);
                }
            })
            .catch(error => {
                toastr.error(error.response?.data?.message || 'Failed to update cart');
            });
        }

        // Remove cart item
        function removeCartItem(cartKey) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) return;
            
            axios.post('{{ route("cart.remove") }}', {
                cart_key: cartKey,
                _token: '{{ csrf_token() }}'
            })
            .then(response => {
                if (response.data.success) {
                    toastr.success(response.data.message);
                    
                    // Update cart count in navigation
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = response.data.cart_count;
                        el.style.display = response.data.cart_count > 0 ? 'inline-block' : 'none';
                    });
                    
                    // Update cart count badge
                    document.querySelector('.cart-count-badge').textContent = 
                        response.data.cart_count + (response.data.cart_count === 1 ? ' item' : ' items');
                    
                    // Remove the row
                    document.querySelector(`.cart-item[data-cart-key="${cartKey}"]`).remove();
                    
                    // Update order summary
                    updateOrderSummary(response.data);
                    
                    // If cart is empty, reload page to show empty cart message
                    if (response.data.cart_count === 0) {
                        setTimeout(() => location.reload(), 1000);
                    }
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(error => {
                toastr.error(error.response?.data?.message || 'Failed to remove item');
            });
        }

        // Clear entire cart
        function clearCart() {
            if (!confirm('Are you sure you want to clear your cart?')) return;
            
            axios.post('{{ route("cart.clear") }}', {
                _token: '{{ csrf_token() }}'
            })
            .then(response => {
                if (response.data.success) {
                    toastr.success(response.data.message);
                    setTimeout(() => location.reload(), 1500);
                }
            })
            .catch(error => {
                toastr.error('Failed to clear cart');
            });
        }

        // Add product to cart from related products
        function addToCart(productId) {
            axios.post('{{ route("cart.add") }}', {
                product_id: productId,
                quantity: 1,
                _token: '{{ csrf_token() }}'
            })
            .then(response => {
                if (response.data.success) {
                    toastr.success(response.data.message);
                    
                    // Update cart count in navigation
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = response.data.cart_count;
                        el.style.display = response.data.cart_count > 0 ? 'inline-block' : 'none';
                    });
                    
                    // Update cart count badge
                    document.querySelector('.cart-count-badge').textContent = 
                        response.data.cart_count + (response.data.cart_count === 1 ? ' item' : ' items');
                    
                    // Refresh the cart page to show new item
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(error => {
                toastr.error(error.response?.data?.message || 'Failed to add to cart');
            });
        }

        // Update order summary values
        function updateOrderSummary(data) {
            document.getElementById('subtotal').textContent = '₦ ' + parseFloat(data.subtotal).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            
            // Update shipping display
            const shippingEl = document.querySelector('.summary-row:nth-child(2) span:nth-child(2)');
            shippingEl.textContent = data.shipping == 0 ? 'FREE' : '₦ ' + parseFloat(data.shipping).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            shippingEl.className = data.shipping == 0 ? 'text-success' : '';
            
            document.getElementById('tax').textContent = '₦ ' + parseFloat(data.tax).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            document.getElementById('total').textContent = '₦ ' + parseFloat(data.total).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    </script>
</body>

</html>