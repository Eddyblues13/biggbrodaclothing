<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Essence - Fashion Ecommerce Template</title>

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('assets/img/core-img/favicon.png') }}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">

    <!-- Add these CDNs to your layout -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>


</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="index.html">
                    <img src="assets/img/core-img/logo.png" alt="" style="width: 100px; height: auto;">
                </a>

                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <div class="classynav">
                        <ul>
                            <li><a href="#">Shop</a>
                                <div class="megamenu">
                                    <ul class="single-mega cn-col-4">
                                        <li class="title">Women's Collection</li>
                                        <li><a href="shop.html">Dresses</a></li>
                                        <li><a href="shop.html">Blouses &amp; Shirts</a></li>
                                        <li><a href="shop.html">T-shirts</a></li>
                                        <li><a href="shop.html">Rompers</a></li>
                                        <li><a href="shop.html">Bras &amp; Panties</a></li>
                                    </ul>
                                    <ul class="single-mega cn-col-4">
                                        <li class="title">Men's Collection</li>
                                        <li><a href="shop.html">T-Shirts</a></li>
                                        <li><a href="shop.html">Polo</a></li>
                                        <li><a href="shop.html">Shirts</a></li>
                                        <li><a href="shop.html">Jackets</a></li>
                                        <li><a href="shop.html">Trench</a></li>
                                    </ul>
                                    <ul class="single-mega cn-col-4">
                                        <li class="title">Kid's Collection</li>
                                        <li><a href="shop.html">Dresses</a></li>
                                        <li><a href="shop.html">Shirts</a></li>
                                        <li><a href="shop.html">T-shirts</a></li>
                                        <li><a href="shop.html">Jackets</a></li>
                                        <li><a href="shop.html">Trench</a></li>
                                    </ul>
                                    <div class="single-mega cn-col-4">
                                        <img src="assets/img/bg-img/bg-6.jpg" alt="">
                                    </div>
                                </div>
                            </li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="shop.html">Shop</a></li>
                                    <li><a href="single-product-details.html">Product Details</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="single-blog.html">Single Blog</a></li>
                                    <li><a href="regular-page.html">Regular Page</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                            </li>
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="contact.html">Contact</a></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                    <form action="#" method="post">
                        <input type="search" name="search" id="headerSearch" placeholder="Type for search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <!-- Favourite Area -->
                <div class="favourite-area">
                    <a href="{{ route('favorites.list') }}">
                        <img src="{{ asset('assets/img/core-img/heart.svg') }}" alt="">
                        <span class="favorite-count">{{ count(session('favorites', [])) }}</span>
                    </a>
                </div>
                <!-- User Login Info -->
                <div class="user-login-info">
                    @auth
                    <a href=""><img src="{{ asset('assets/img/core-img/user.svg') }}" alt=""></a>
                    @else
                    <a href=""><img src="{{ asset('assets/img/core-img/user.svg') }}" alt=""></a>
                    @endauth
                </div>
                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn"><img src="{{ asset('assets/img/core-img/bag.svg') }}" alt="">
                        <span class="cart-count">{{ $cartCount ?? 0 }}</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Right Side Cart Area ##### -->
    <div class="cart-bg-overlay"></div>

    <div class="right-side-cart-area">
        <!-- Cart Button -->
        <div class="cart-button">
            <a href="#" id="rightSideCart"><img src="{{ asset('assets/img/core-img/bag.svg') }}" alt="">
                <span class="cart-count">{{ $cartCount ?? 0 }}</span>
            </a>
        </div>

        <div class="cart-content d-flex">
            <!-- Cart List Area -->
            <div class="cart-list" id="cartItemsContainer">
                @if(count($cart = session('cart', [])) > 0)
                @foreach($cart as $id => $item)
                <div class="single-cart-item" id="cart-item-{{ $id }}">
                    <a href="{{ route('products.show', $item['slug']) }}" class="product-image">
                        <!-- <img src="{{ asset($item['image']) }}" class="cart-thumb" alt="{{ $item['name'] }}"> -->
                        <img src="assets/img/product-img/product-1.jpg" class="cart-thumb" alt="">
                        <div class="cart-item-desc">
                            <span class="product-remove" onclick="removeFromCart({{ $id }})">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </span>
                            <span class="badge">{{ $item['brand'] ?? 'Brand' }}</span>
                            <h6>{{ $item['name'] }}</h6>
                            <div class="cart-item-meta">
                                <p class="price">${{ number_format($item['price'], 2) }}</p>
                                <div class="cart-item-quantity">
                                    <button class="qty-minus" onclick="updateQuantity({{ $id }}, -1)">-</button>
                                    <input type="text" class="qty-text" value="{{ $item['quantity'] }}" readonly>
                                    <button class="qty-plus" onclick="updateQuantity({{ $id }}, 1)">+</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                @else
                <div class="empty-cart-message">
                    <p>Your cart is empty</p>
                </div>
                @endif
            </div>

            <!-- Cart Summary -->
            <div class="cart-amount-summary">
                <h2>Summary</h2>
                <ul class="summary-table">
                    <li><span>subtotal:</span> <span id="cart-subtotal">${{ number_format($cartSubtotal ?? 0, 2)
                            }}</span></li>
                    <li><span>delivery:</span> <span>Free</span></li>
                    <li><span>discount:</span> <span id="cart-discount">${{ number_format($cartDiscount ?? 0, 2)
                            }}</span></li>
                    <li><span>total:</span> <span id="cart-total">${{ number_format($cartTotal ?? 0, 2) }}</span></li>
                </ul>
                <div class="checkout-btn mt-100">
                    <a href="" class="btn essence-btn {{ $cartCount ? '' : 'disabled' }}">check
                        out</a>
                </div>
            </div>
        </div>
    </div>

    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="{{ asset('assets/js/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/active.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>

    <script>
        // Initialize toastr
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
            
                    function updateQuantity(productId, change) {
                        $.ajax({
                            url: '{{ route("cart.update") }}',
                            method: 'POST',
                            data: {
                                product_id: productId,
                                change: change,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if(response.success) {
                                    toastr.success(response.message);
                                    refreshCartData();
                                    if(response.item_removed) {
                                        $('#cart-item-' + productId).remove();
                                    }
                                }
                            }
                        });
                    }
            
                    function removeFromCart(productId) {
                        $.ajax({
                            url: '{{ route("cart.remove") }}',
                            method: 'POST',
                            data: {
                                product_id: productId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if(response.success) {
                                    toastr.success(response.message);
                                    $('#cart-item-' + productId).remove();
                                    refreshCartData();
                                }
                            }
                        });
                    }
            
                    function refreshCartData() {
                        $.get('{{ route("cart.data") }}', function(response) {
                            if(response.success) {
                                // Update cart counts
                                $('.cart-count').text(response.cart_count);
                                
                                // Update summary
                                $('#cart-subtotal').text('$' + response.subtotal.toFixed(2));
                                $('#cart-discount').text('-$' + response.discount.toFixed(2));
                                $('#cart-total').text('$' + response.total.toFixed(2));
                                
                                // Toggle checkout button
                                $('.checkout-btn a').toggleClass('disabled', response.cart_count === 0);
                                
                                // Update cart items
                                if(response.cart_count > 0) {
                                    let itemsHtml = '';
                                    $.each(response.cart_items, function(id, item) {
                                        itemsHtml += `
                                            <div class="single-cart-item" id="cart-item-${id}">
                                                <a href="/products/${item.slug}" class="product-image">
                                                    <img src="${item.image}" class="cart-thumb" alt="${item.name}">
                                                    <div class="cart-item-desc">
                                                        <span class="product-remove" onclick="removeFromCart(${id})">
                                                            <i class="fa fa-close" aria-hidden="true"></i>
                                                        </span>
                                                        <span class="badge">${item.brand}</span>
                                                        <h6>${item.name}</h6>
                                                        <div class="cart-item-meta">
                                                            <p class="price">$${item.price.toFixed(2)}</p>
                                                            <div class="cart-item-quantity">
                                                                <button class="qty-minus" onclick="updateQuantity(${id}, -1)">-</button>
                                                                <input type="text" class="qty-text" value="${item.quantity}" readonly>
                                                                <button class="qty-plus" onclick="updateQuantity(${id}, 1)">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        `;
                                    });
                                    $('#cartItemsContainer').html(itemsHtml);
                                } else {
                                    $('#cartItemsContainer').html('<div class="empty-cart-message"><p>Your cart is empty</p></div>');
                                }
                            }
                        });
                    }
    </script>