@include("home.header")

<!-- Breadcrumb -->
<section class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Product Detail -->
<section class="product-detail py-5">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 mb-4">
                <div class="product-gallery position-relative">
                    @if($product->is_on_sale)
                    <div class="sale-badge">
                        {{ $product->discount_percentage }}% OFF
                    </div>
                    @endif

                    <div class="main-image mb-3">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded"
                            id="mainProductImage">
                    </div>
                    <div class="thumbnail-images">
                        <div class="row g-2">
                            <div class="col-3">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="img-fluid rounded thumbnail-img active" onclick="changeMainImage(this)">
                            </div>
                            @if($product->gallery_urls)
                            @foreach(array_slice($product->gallery_urls, 0, 3) as $imageUrl)
                            <div class="col-3">
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                                    class="img-fluid rounded thumbnail-img" onclick="changeMainImage(this)">
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <input type="hidden" id="productId" value="{{ $product->id }}">
                <input type="hidden" id="productStock" value="{{ $product->stock }}">

                <div class="product-info">
                    <h1 class="product-title mb-3">
                        {{ strtoupper($product->name) }}
                    </h1>

                    <div class="product-price mb-4">
                        <span class="current-price">₦ {{ number_format($product->current_price, 2) }}</span>
                        @if($product->is_on_sale)
                        <span class="original-price">₦ {{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <div class="product-description mb-4">
                        <p>{{ $product->description }}</p>
                    </div>

                    <!-- Size Selection -->
                    @if($product->available_sizes)
                    <div class="size-selection mb-4">
                        <h6 class="mb-3">Size</h6>
                        <div class="size-options">
                            @foreach($product->available_sizes as $size)
                            <input type="radio" class="btn-check" name="size" id="size-{{ $size }}" value="{{ $size }}"
                                {{ $loop->first ? 'checked' : '' }}>
                            <label class="btn btn-outline-secondary me-2 mb-2" for="size-{{ $size }}">{{ $size
                                }}</label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Quantity -->
                    <div class="quantity-selection mb-4">
                        <h6 class="mb-3">Quantity</h6>
                        <div class="input-group" style="max-width: 150px;">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="decreaseQuantity()">-</button>
                            <input type="text" class="form-control text-center" value="1" id="quantity" readonly>
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="increaseQuantity()">+</button>
                        </div>
                        <div class="stock-message mt-2">
                            @if($product->stock > 10)
                            <span class="text-success"><i class="fas fa-check-circle me-1"></i> In stock</span>
                            @elseif($product->stock > 0)
                            <span class="text-warning"><i class="fas fa-exclamation-circle me-1"></i> Only {{
                                $product->stock }} left</span>
                            @else
                            <span class="text-danger"><i class="fas fa-times-circle me-1"></i> Out of stock</span>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons mb-4">
                        <button class="btn btn-outline-light me-3 mb-2" id="addToCartBtn" onclick="addToCart()">
                            <i class="fas fa-shopping-cart me-2"></i>ADD TO CART
                        </button>
                        <button class="btn btn-outline-secondary mb-2" onclick="addToWishlist()">
                            <i class="fas fa-heart me-2"></i>WISHLIST
                        </button>
                    </div>

                    <!-- Product Details -->
                    <div class="product-details">
                        <div class="accordion" id="productAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#details">
                                        PRODUCT DETAILS
                                    </button>
                                </h2>
                                <div id="details" class="accordion-collapse collapse"
                                    data-bs-parent="#productAccordion">
                                    <div class="accordion-body">
                                        @if($product->short_description)
                                        {!! nl2br(e($product->short_description)) !!}
                                        @else
                                        <p>No additional details available for this product.</p>
                                        @endif

                                        @if($product->brand)
                                        <p class="mt-3"><strong>Brand:</strong> {{ $product->brand }}</p>
                                        @endif

                                        @if($product->sku)
                                        <p><strong>SKU:</strong> {{ $product->sku }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#shipping">
                                        SHIPPING & RETURNS
                                    </button>
                                </h2>
                                <div id="shipping" class="accordion-collapse collapse"
                                    data-bs-parent="#productAccordion">
                                    <div class="accordion-body">
                                        <p>Free shipping on orders over ₦500,000. Standard delivery takes 3-5
                                            business days. Returns accepted within 30 days of purchase.</p>
                                        <p>For international shipping, please contact customer service for rates and
                                            delivery times.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="related-products py-5">
    <div class="container">
        <h2 class="section-title mb-4">YOU MAY ALSO LIKE</h2>
        <div class="row">
            @foreach($relatedProducts as $related)
            <div class="col-md-3 col-6 mb-4">
                <div class="product-card">
                    <a href="{{ route('product.show', $related->slug) }}" class="text-decoration-none text-dark">
                        <div class="product-image position-relative">
                            @if($related->is_on_sale)
                            <div class="discount-badge">
                                SALE
                            </div>
                            @endif
                            <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="img-fluid">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ $related->name }}</h3>
                            <p class="product-price">
                                ₦ {{ number_format($related->current_price, 2) }}
                                @if($related->is_on_sale)
                                <span class="original-price">₦ {{ number_format($related->price, 2) }}</span>
                                @endif
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif



<script>
    // Initialize Toastr
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            extendedTimeOut: 1000,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };

        // Quantity functions
        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const stock = parseInt(document.getElementById('productStock').value);
            let value = parseInt(input.value) || 1;
            
            if (value < stock) {
                input.value = value + 1;
            } else {
                toastr.warning(`Only ${stock} items available`);
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            let value = parseInt(input.value) || 1;
            if (value > 1) {
                input.value = value - 1;
            }
        }

        // Add to cart function
        function addToCart() {
            const productId = document.getElementById('productId').value;
            const quantity = parseInt(document.getElementById('quantity').value);
            const stock = parseInt(document.getElementById('productStock').value);
            const size = document.querySelector('input[name="size"]:checked')?.value || '';
            
            // Disable button during request
            const btn = document.getElementById('addToCartBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> ADDING...';
            
            // Check stock
            if (quantity > stock) {
                toastr.error(`Only ${stock} items available`);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i> ADD TO CART';
                return;
            }
            
            // Send request
            axios.post('{{ route("cart.add") }}', {
                product_id: productId,
                quantity: quantity,
                size: size,
                _token: '{{ csrf_token() }}'
            })
            .then(response => {
                if (response.data.success) {
                    toastr.success(response.data.message);
                    
                    // Update all cart badges
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = response.data.cart_count;
                        el.style.display = response.data.cart_count > 0 ? 'inline-block' : 'none';
                    });
                } else {
                    toastr.error(response.data.message);
                }
            })
            .catch(error => {
                let message = 'Failed to add to cart';
                if (error.response && error.response.data && error.response.data.message) {
                    message = error.response.data.message;
                }
                toastr.error(message);
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i> ADD TO CART';
            });
        }

        // Add to wishlist function
        function addToWishlist() {
            toastr.info('Wishlist feature is coming soon!');
        }

        // Image gallery function
        function changeMainImage(element) {
            document.querySelectorAll('.thumbnail-img').forEach(img => {
                img.classList.remove('active');
            });
            element.classList.add('active');
            document.getElementById('mainProductImage').src = element.src;
        }

        // Size button styling
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize size selection
            const checkedInput = document.querySelector('input[name="size"]:checked');
            if (checkedInput) {
                const label = document.querySelector(`label[for="${checkedInput.id}"]`);
                label.style.backgroundColor = '#cca264';
                label.style.color = 'white';
            }
            
            // Size selection styling
            document.querySelectorAll('input[name="size"]').forEach(input => {
                input.addEventListener('change', function() {
                    document.querySelectorAll('label[for^="size-"]').forEach(label => {
                        label.style.backgroundColor = '';
                        label.style.color = '';
                    });
                    
                    if (this.checked) {
                        const label = document.querySelector(`label[for="${this.id}"]`);
                        label.style.backgroundColor = '#cca264';
                        label.style.color = 'white';
                    }
                });
            });
        });
</script>
@include("home.footer")