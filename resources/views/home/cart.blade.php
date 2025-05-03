@include("home.header")

    <!-- Main Content -->
    <div class="container py-5 page-container mt-5 bg-light">
        <h1 class="page-title">Shopping Cart</h1>

        <div class="row g-4">
            <!-- Cart Items Section -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>
                            <i class="bi bi-cart me-2"></i>
                            Cart Items (3)
                        </h5>
                        <span class="badge bg-success rounded-pill">Free Shipping on orders over ₦100</span>
                    </div>
                    
                    <div class="card-body">
                        <!-- Item 1 -->
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-md-2 col-3">
                                    <img src="https://via.placeholder.com/100" alt="Premium Casual Gray T-Shirt" class="product-image">
                                </div>
                                
                                <div class="col-md-10 col-9">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h3 class="product-name">Premium Casual Gray T-Shirt</h3>
                                            <div class="product-details">
                                                Size: M | Color: Gray
                                            </div>
                                            <div class="stock-status in-stock">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                In Stock
                                            </div>
                                            <div class="delivery-info">
                                                <i class="bi bi-truck"></i>
                                                Estimated delivery: May 5 - May 8
                                            </div>
                                            <button class="remove-btn">
                                                <i class="bi bi-trash me-1"></i>
                                                REMOVE
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-5 mt-3 mt-md-0">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="quantity-control">
                                                    <button class="quantity-btn decrease-btn" data-id="1">
                                                        -
                                                    </button>
                                                    <input type="text" class="quantity-input" id="qty-1" value="2" readonly>
                                                    <button class="quantity-btn increase-btn" data-id="1">
                                                        +
                                                    </button>
                                                </div>
                                                
                                                <div class="text-end">
                                                    <div class="product-price">₦59.98</div>
                                                    <div>
                                                        <span class="product-original-price">₦79.98</span>
                                                        <span class="product-discount">-25%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Item 2 -->
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-md-2 col-3">
                                    <img src="https://via.placeholder.com/100" alt="Designer Denim Jeans - Slim Fit" class="product-image">
                                </div>
                                
                                <div class="col-md-10 col-9">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h3 class="product-name">Designer Denim Jeans - Slim Fit</h3>
                                            <div class="product-details">
                                                Size: 32 | Color: Blue
                                            </div>
                                            <div class="stock-status in-stock">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                In Stock
                                            </div>
                                            <div class="delivery-info">
                                                <i class="bi bi-truck"></i>
                                                Estimated delivery: May 5 - May 8
                                            </div>
                                            <button class="remove-btn">
                                                <i class="bi bi-trash me-1"></i>
                                                REMOVE
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-5 mt-3 mt-md-0">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="quantity-control">
                                                    <button class="quantity-btn decrease-btn" data-id="2">
                                                        -
                                                    </button>
                                                    <input type="text" class="quantity-input" id="qty-2" value="1" readonly>
                                                    <button class="quantity-btn increase-btn" data-id="2">
                                                        +
                                                    </button>
                                                </div>
                                                
                                                <div class="text-end">
                                                    <div class="product-price">₦49.99</div>
                                                    <div>
                                                        <span class="product-original-price">₦59.99</span>
                                                        <span class="product-discount">-17%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Item 3 -->
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-md-2 col-3">
                                    <img src="https://via.placeholder.com/100" alt="Professional Running Shoes - Sport Edition" class="product-image">
                                </div>
                                
                                <div class="col-md-10 col-9">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h3 class="product-name">Professional Running Shoes - Sport Edition</h3>
                                            <div class="product-details">
                                                Size: 42 | Color: Black/Red
                                            </div>
                                            <div class="stock-status in-stock">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                Only 2 left in stock
                                            </div>
                                            <div class="delivery-info">
                                                <i class="bi bi-truck"></i>
                                                Estimated delivery: May 6 - May 9
                                            </div>
                                            <button class="remove-btn">
                                                <i class="bi bi-trash me-1"></i>
                                                REMOVE
                                            </button>
                                        </div>
                                        
                                        <div class="col-md-5 mt-3 mt-md-0">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="quantity-control">
                                                    <button class="quantity-btn decrease-btn" data-id="3">
                                                        -
                                                    </button>
                                                    <input type="text" class="quantity-input" id="qty-3" value="1" readonly>
                                                    <button class="quantity-btn increase-btn" data-id="3">
                                                        +
                                                    </button>
                                                </div>
                                                
                                                <div class="text-end">
                                                    <div class="product-price">₦89.99</div>
                                                    <div>
                                                        <span class="product-original-price">₦109.99</span>
                                                        <span class="product-discount">-18%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <span class="summary-label">Subtotal (4 items)</span>
                            <span class="summary-value">₦199.96</span>
                        </div>
                        
                        <div class="summary-row">
                            <span class="summary-label">Shipping Fee</span>
                            <span class="summary-value">FREE</span>
                        </div>
                        
                        <div class="summary-row">
                            <span class="summary-label">Tax (5%)</span>
                            <span class="summary-value">₦10.00</span>
                        </div>
                        
                        <div class="summary-row total">
                            <span>Total</span>
                            <span>₦209.96</span>
                        </div>
                        
                        <button class="checkout-btn">
                            PROCEED TO CHECKOUT
                            <i class="bi bi-chevron-right ms-2"></i>
                        </button>
                        
                        <a href="#" class="continue-shopping">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Subtotal Bar -->
        <div class="subtotal-mobile">
            <div>
                <div class="fw-bold">₦209.96</div>
                <div class="text-muted small">View details</div>
            </div>
            <button class="checkout-btn" style="width: auto; margin: 0; padding: 10px 16px;">
                CHECKOUT
            </button>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all increment and decrement buttons
            const increaseButtons = document.querySelectorAll('.increase-btn');
            const decreaseButtons = document.querySelectorAll('.decrease-btn');
            
            // Add event listeners to increment buttons
            increaseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const quantityInput = document.getElementById(`qty-${id}`);
                    
                    // Increment quantity
                    let quantity = parseInt(quantityInput.value);
                    quantity++;
                    quantityInput.value = quantity;
                    
                    // Enable decrease button if quantity > 1
                    const decreaseBtn = document.querySelector(`.decrease-btn[data-id="${id}"]`);
                    if (quantity > 1) {
                        decreaseBtn.disabled = false;
                    }
                });
            });
            
            // Add event listeners to decrement buttons
            decreaseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const quantityInput = document.getElementById(`qty-${id}`);
                    
                    // Decrement quantity if > 1
                    let quantity = parseInt(quantityInput.value);
                    if (quantity > 1) {
                        quantity--;
                        quantityInput.value = quantity;
                        
                        // Disable decrease button if quantity = 1
                        if (quantity === 1) {
                            this.disabled = true;
                        }
                    }
                });
            });
            
            // Initialize decrease buttons (disable if quantity = 1)
            decreaseButtons.forEach(button => {
                const id = button.getAttribute('data-id');
                const quantityInput = document.getElementById(`qty-${id}`);
                if (parseInt(quantityInput.value) === 1) {
                    button.disabled = true;
                }
            });
        });
    </script>



@include("home.footer")