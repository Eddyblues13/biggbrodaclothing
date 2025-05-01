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
                    <h2>New Collection</h2>
                    <a href="#" class="btn essence-btn">view collection</a>
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
                        <div class="product-img">
                            {{-- <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            <!-- Hover Thumb -->
                            @if(count($product->gallery_urls) > 0)
                            <img class="hover-img" src="{{ $product->gallery_urls[0] }}" alt="{{ $product->name }}">
                            @endif --}}

                            <img src="assets/img/product-img/product-3.jpg" alt="">
                            <!-- Hover Thumb -->
                            <img class="hover-img" src="assets/img/product-img/product-4.jpg" alt="">


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

<script>
    $(document).ready(function() {
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

        // Add to cart functionality
        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            
            var productId = $(this).data('product-id');
            var button = $(this);
            
            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    button.html('<i class="fa fa-spinner fa-spin"></i> Adding...');
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        // Reload the page to update all cart data
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred. Please try again.');
                },
                complete: function() {
                    button.html('Add to Cart');
                }
            });
        });

        // Add to favorite functionality
        $(document).on('click', '.favme', function(e) {
            e.preventDefault();
            
            var productId = $(this).data('product-id');
            var heartIcon = $(this);
            
            $.ajax({
                url: '{{ route("favorites.toggle") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    heartIcon.html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    if (response.success) {
                        if (response.action === 'added') {
                            toastr.success('Added to favorites');
                        } else {
                            toastr.success('Removed from favorites');
                        }
                        // Reload the page to update all data
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred. Please try again.');
                },
                complete: function() {
                    heartIcon.html('<i class="fa fa-heart"></i>');
                }
            });
        });

        // Function to refresh cart sidebar
        function refreshCartSidebar() {
            $.get('{{ route("cart.data") }}', function(response) {
                if (response.success) {
                    var cartItemsContainer = $('#cartItemsContainer');
                    
                    if (response.cart_count > 0) {
                        var itemsHtml = '';
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
                        cartItemsContainer.html(itemsHtml);
                        $('.empty-cart-message').remove();
                        $('.checkout-btn a').removeClass('disabled');
                    } else {
                        cartItemsContainer.html('<div class="empty-cart-message"><p>Your cart is empty</p></div>');
                        $('.checkout-btn a').addClass('disabled');
                    }
                    
                    // Update summary
                    $('#cart-subtotal').text('$' + response.subtotal.toFixed(2));
                    $('#cart-discount').text('-$' + response.discount.toFixed(2));
                    $('#cart-total').text('$' + response.total.toFixed(2));
                }
            });
        }

        // Initialize cart sidebar on page load
        refreshCartSidebar();
    });

    // Global functions for cart operations
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
                    // Reload the page to update all data
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message);
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
                    // Reload the page to update all data
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    }
</script>