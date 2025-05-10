@include("home.header")

<!-- Main Content -->
<div class="container py-5 page-container mt-5 bg-light">
    <h1 class="page-title">Shopping Cart</h1>

    @if($cartCount === 0)
    <div class="empty-cart-message text-center py-5">
        <i class="bi bi-cart-x" style="font-size: 5rem; color: #ddd;"></i>
        <h3 class="my-4">Your cart is empty</h3>
        <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">
            Continue Shopping
        </a>
    </div>
    @else
    <div class="row g-4">
        <!-- Cart Items Section -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>
                        <i class="bi bi-cart me-2"></i>
                        Cart Items (<span class="cart-count">{{ $cartCount }}</span>)
                    </h5>
                    <span class="badge bg-success rounded-pill">Free Shipping on orders over ₦100</span>
                </div>

                <div class="card-body" id="cartItemsContainer">
                    @foreach($cart as $cartKey => $item)
                    @php
                    $product = isset($item['product_id'])
                    ? App\Models\Product::find($item['product_id'])
                    : null;
                    @endphp

                    @if($product)
                    <div class="cart-item mb-4 pb-4 border-bottom" id="cart-item-{{ $cartKey }}">
                        <div class="row">
                            <div class="col-md-2 col-3">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                    class="product-image img-fluid">
                            </div>

                            <div class="col-md-10 col-9">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h3 class="product-name">
                                            <a href="{{ route('products.show', $item['slug']) }}">
                                                {{ $item['name'] }}
                                            </a>
                                        </h3>
                                        @if(!empty($item['size']) || !empty($item['color']))
                                        <div class="product-details">
                                            @if(!empty($item['size']))
                                            Size: {{ $item['size'] }}
                                            @endif
                                            @if(!empty($item['color']))
                                            | Color: {{ $item['color'] }}
                                            @endif
                                        </div>
                                        @endif
                                        <div
                                            class="stock-status {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                                            <i
                                                class="bi {{ $product->stock > 0 ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill' }} me-1"></i>
                                            @if($product->stock > 0)
                                            @if($product->stock < 5) Only {{ $product->stock }} left in stock
                                                @else
                                                In Stock
                                                @endif
                                                @else
                                                Out of Stock
                                                @endif
                                        </div>
                                        <div class="delivery-info">
                                            <i class="bi bi-truck"></i>
                                            Estimated delivery: {{ $item['delivery_date'] ??
                                            now()->addDays(3)->format('M d') }}
                                        </div>
                                        <button class="remove-btn" onclick="removeFromCart('{{ $cartKey }}')">
                                            <i class="bi bi-trash me-1"></i>
                                            REMOVE
                                        </button>
                                    </div>

                                    <div class="col-md-5 mt-3 mt-md-0">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="quantity-control">
                                                <button class="quantity-btn decrease-btn"
                                                    onclick="updateQuantity('{{ $cartKey }}', -1)" {{ $item['quantity']
                                                    <=1 ? 'disabled' : '' }}>
                                                    -
                                                </button>
                                                <input type="text" class="quantity-input"
                                                    value="{{ $item['quantity'] }}" readonly>
                                                <button class="quantity-btn increase-btn"
                                                    onclick="updateQuantity('{{ $cartKey }}', 1)" {{ ($product->stock <=
                                                        $item['quantity']) ? 'disabled' : '' }}>
                                                        +
                                                </button>
                                            </div>

                                            <div class="text-end">
                                                <div class="product-price">₦{{ number_format($item['price'] *
                                                    $item['quantity'], 2) }}</div>
                                                @if($item['price'] < $product->price)
                                                    <div>
                                                        <span class="product-original-price">₦{{
                                                            number_format($product->price * $item['quantity'], 2)
                                                            }}</span>
                                                        <span class="product-discount">-{{ $product->discount_percentage
                                                            }}%</span>
                                                    </div>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="invalid-product alert alert-warning mb-4">
                        This product is no longer available
                        <button class="btn btn-sm btn-danger ms-3" onclick="removeFromCart('{{ $cartKey }}')">
                            Remove Item
                        </button>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary Section -->
        <div class="col-lg-4">
            <div class="summary-card">
                <div class="summary-header">
                    <h5 class="summary-title">Order Summary</h5>
                </div>

                <div class="summary-body">
                    <div class="summary-row">
                        <span class="summary-label">Subtotal (<span class="cart-count">{{ $cartCount }}</span>
                            items)</span>
                        <span class="summary-value" id="cart-subtotal">₦{{ number_format($cartSubtotal, 2) }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Shipping Fee</span>
                        <span class="summary-value" id="cart-shipping">
                            {{ $cartShipping === 0 ? 'FREE' : '₦'.number_format($cartShipping, 2) }}
                        </span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Tax (5%)</span>
                        <span class="summary-value" id="cart-tax">₦{{ number_format($cartTax, 2) }}</span>
                    </div>

                    <div class="summary-row total">
                        <span>Total</span>
                        <span id="cart-total">₦{{ number_format($cartTotal, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout') }}" class="checkout-btn">
                        PROCEED TO CHECKOUT
                        <i class="bi bi-chevron-right ms-2"></i>
                    </a>

                    <a href="{{ route('products.index') }}" class="continue-shopping">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Subtotal Bar -->
    <div class="subtotal-mobile">
        <div>
            <div class="fw-bold" id="mobile-cart-total">₦{{ number_format($cartTotal, 2) }}</div>
            <div class="text-muted small">View details</div>
        </div>
        <a href="" class="checkout-btn" style="width: auto; margin: 0; padding: 10px 16px;">
            CHECKOUT
        </a>
    </div>
    @endif
</div>

@include("home.footer")

<script>
    $(document).ready(function () {
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
    });

    function refreshCartData() {
        $.get('{{ route("cart.data") }}', function(response) {
            if (response.success) {
                // Update counts and totals
                $('.cart-count').text(response.cart_count);
                $('#cart-subtotal').text('₦' + response.subtotal.toFixed(2));
                $('#cart-shipping').text(response.shipping === 0 ? 'FREE' : '₦' + response.shipping.toFixed(2));
                $('#cart-tax').text('₦' + response.tax.toFixed(2));
                $('#cart-total').text('₦' + response.total.toFixed(2));
                $('#mobile-cart-total').text('₦' + response.total.toFixed(2));

                // Update cart items
                let itemsHtml = '';
                $.each(response.cart_items, function(cartKey, item) {
                    if (!item.product) {
                        itemsHtml += `
                            <div class="invalid-product alert alert-warning mb-4">
                                This product is no longer available
                                <button class="btn btn-sm btn-danger ms-3" 
                                        onclick="removeFromCart('${cartKey}')">
                                    Remove Item
                                </button>
                            </div>`;
                        return;
                    }

                    const stockStatus = item.product.stock > 0 ? 'in-stock' : 'out-of-stock';
                    const stockIcon = item.product.stock > 0 ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';
                    const stockMessage = item.product.stock > 0 
                        ? (item.product.stock < 5 ? `Only ${item.product.stock} left` : 'In Stock')
                        : 'Out of Stock';

                    itemsHtml += `
                        <div class="cart-item mb-4 pb-4 border-bottom" id="cart-item-${cartKey}">
                            ${renderCartItem(item, cartKey, stockStatus, stockIcon, stockMessage)}
                        </div>`;
                });

                $('#cartItemsContainer').html(itemsHtml);
                
                if (response.cart_count === 0) {
                    window.location.reload();
                }
            }
        }).fail(() => toastr.error('Failed to update cart'));
    }

    function renderCartItem(item, cartKey, stockStatus, stockIcon, stockMessage) {
        return `
            <div class="row">
                <div class="col-md-2 col-3">
                    <img src="${item.image}" alt="${item.name}" class="product-image img-fluid">
                </div>
                <div class="col-md-10 col-9">
                    <div class="row">
                        <div class="col-md-7">
                            <h3 class="product-name">
                                <a href="/products/${item.product.slug}">${item.name}</a>
                            </h3>
                            ${renderVariations(item)}
                            <div class="stock-status ${stockStatus}">
                                <i class="bi ${stockIcon} me-1"></i>${stockMessage}
                            </div>
                            <div class="delivery-info">
                                <i class="bi bi-truck"></i>Est. delivery: ${item.delivery_date}
                            </div>
                            <button class="remove-btn" onclick="removeFromCart('${cartKey}')">
                                <i class="bi bi-trash me-1"></i>REMOVE
                            </button>
                        </div>
                        <div class="col-md-5 mt-3 mt-md-0">
                            ${renderQuantityControls(item, cartKey)}
                            ${renderPricing(item)}
                        </div>
                    </div>
                </div>
            </div>`;
    }

    function renderVariations(item) {
        if (!item.size && !item.color) return '';
        return `
            <div class="product-details">
                ${item.size ? `Size: ${item.size}` : ''}
                ${item.size && item.color ? ' | ' : ''}
                ${item.color ? `Color: ${item.color}` : ''}
            </div>`;
    }

    function renderQuantityControls(item, cartKey) {
        const decreaseDisabled = item.quantity <= 1 ? 'disabled' : '';
        const increaseDisabled = item.product.stock <= item.quantity ? 'disabled' : '';
        
        return `
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="quantity-control">
                    <button class="quantity-btn decrease-btn" onclick="updateQuantity('${cartKey}', -1)" ${decreaseDisabled}>
                        -
                    </button>
                    <input type="text" class="quantity-input" value="${item.quantity}" readonly>
                    <button class="quantity-btn increase-btn" onclick="updateQuantity('${cartKey}', 1)" ${increaseDisabled}>
                        +
                    </button>
                </div>
                ${renderPricing(item)}
            </div>`;
    }

    function renderPricing(item) {
        const discountHtml = item.price < item.product.price 
            ? `<div>
                <span class="product-original-price">₦${(item.product.price * item.quantity).toFixed(2)}</span>
                <span class="product-discount">-${item.product.discount_percentage}%</span>
               </div>`
            : '';
        
        return `
            <div class="text-end">
                <div class="product-price">₦${(item.price * item.quantity).toFixed(2)}</div>
                ${discountHtml}
            </div>`;
    }

    function updateQuantity(cartKey, change) {
        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                cart_key: cartKey,
                change: change,
                _token: '{{ csrf_token() }}'
            },
            success: (response) => {
                if (response.success) {
                    toastr.success(response.message);
                    if (response.item_removed) {
                        $(`#cart-item-${cartKey}`).remove();
                    }
                    refreshCartData();
                } else {
                    toastr.error(response.message);
                }
            },
            error: (xhr) => toastr.error(xhr.responseJSON?.message || 'Update failed')
        });
    }

    function removeFromCart(cartKey) {
        if (confirm('Remove this item from cart?')) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: 'POST',
                data: {
                    cart_key: cartKey,
                    _token: '{{ csrf_token() }}'
                },
                success: (response) => {
                    if (response.success) {
                        toastr.success(response.message);
                        $(`#cart-item-${cartKey}`).remove();
                        refreshCartData();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: (xhr) => toastr.error(xhr.responseJSON?.message || 'Removal failed')
            });
        }
    }
</script>