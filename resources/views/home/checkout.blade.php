@include("home.header")

<section class="checkout-section py-5" style="margin-top: 100px;">
    <div class="container">
        @if($cartAdjusted)
        <div class="alert alert-warning mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Some items in your cart are no longer available or the quantity has been adjusted to the available stock.
        </div>
        @endif

        <div class="row">
            <div class="col-12">
                <h1 class="section-title mb-4">CHECKOUT</h1>

                <!-- Progress Steps -->
                <div class="checkout-progress mb-5">
                    <div class="row">
                        <div class="col-4 text-center">
                            <div class="step active">
                                <div class="step-number">1</div>
                                <div class="step-label">SHIPPING</div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-label">PAYMENT</div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-label">REVIEW</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Checkout Form -->
                <div class="col-lg-8">
                    <!-- Shipping Information -->
                    <div class="checkout-section-card mb-4">
                        <h4 class="section-title mb-4">SHIPPING INFORMATION</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required
                                    value="{{ old('first_name') }}" style="border-color: #e0e0e0;">
                                @error('first_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required
                                    value="{{ old('last_name') }}" style="border-color: #e0e0e0;">
                                @error('last_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="{{ old('email') }}" style="border-color: #e0e0e0;">
                            @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required
                                value="{{ old('phone') }}" style="border-color: #e0e0e0;">
                            @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address1" class="form-label">Street Address *</label>
                            <input type="text" class="form-control" id="address1" name="address1" required
                                value="{{ old('address1') }}" style="border-color: #e0e0e0;">
                            @error('address1')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address2" class="form-label">Address Line 2 (Optional)</label>
                            <input type="text" class="form-control" id="address2" name="address2"
                                value="{{ old('address2') }}" style="border-color: #e0e0e0;">
                            @error('address2')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="city" name="city" required
                                    value="{{ old('city') }}" style="border-color: #e0e0e0;">
                                @error('city')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="state" class="form-label">State *</label>
                                <select class="form-select" id="state" name="state" required
                                    style="border-color: #e0e0e0;">
                                    <option value="">Select State</option>
                                    <option value="lagos" {{ old('state')=='lagos' ? 'selected' : '' }}>Lagos</option>
                                    <option value="abuja" {{ old('state')=='abuja' ? 'selected' : '' }}>Abuja</option>
                                    <option value="kano" {{ old('state')=='kano' ? 'selected' : '' }}>Kano</option>
                                    <option value="rivers" {{ old('state')=='rivers' ? 'selected' : '' }}>Rivers
                                    </option>
                                    <option value="ogun" {{ old('state')=='ogun' ? 'selected' : '' }}>Ogun</option>
                                </select>
                                @error('state')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="postcode" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="postcode" name="postcode"
                                    value="{{ old('postcode') }}" style="border-color: #e0e0e0;">
                                @error('postcode')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="country" value="Nigeria">
                    </div>

                    <!-- Shipping Method -->
                    <div class="checkout-section-card mb-4">
                        <h4 class="section-title mb-4">SHIPPING METHOD</h4>

                        <div class="shipping-options">
                            <div class="form-check mb-3 p-3" style="border: 2px solid #e0e0e0; border-radius: 8px;">
                                <input class="form-check-input" type="radio" name="shipping_method" id="standard"
                                    value="standard" checked>
                                <label class="form-check-label w-100" for="standard">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>Standard Delivery</strong>
                                            <div class="text-muted">3-5 business days</div>
                                        </div>
                                        <div class="text-success">
                                            <strong id="standard-shipping-cost">
                                                @if($shipping == 0)
                                                Free
                                                @else
                                                ₦ {{ number_format($shipping, 2) }}
                                                @endif
                                            </strong>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="form-check mb-3 p-3" style="border: 2px solid #e0e0e0; border-radius: 8px;">
                                <input class="form-check-input" type="radio" name="shipping_method" id="express"
                                    value="express">
                                <label class="form-check-label w-100" for="express">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>Express Delivery</strong>
                                            <div class="text-muted">1-2 business days</div>
                                        </div>
                                        <div><strong>₦ 15,000.00</strong></div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-section-card mb-4">
                        <h4 class="section-title mb-4">PAYMENT METHOD</h4>

                        <div class="payment-options">
                            <div class="form-check mb-3 p-3" style="border: 2px solid #e0e0e0; border-radius: 8px;">
                                <input class="form-check-input" type="radio" name="payment_method" id="card"
                                    value="card" checked>
                                <label class="form-check-label w-100" for="card">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-credit-card me-3" style="color: #cca264;"></i>
                                        <span><strong>Credit/Debit Card</strong></span>
                                    </div>
                                </label>
                            </div>

                            <div class="form-check mb-3 p-3" style="border: 2px solid #e0e0e0; border-radius: 8px;">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer"
                                    value="bank_transfer">
                                <label class="form-check-label w-100" for="bank_transfer">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-university me-3" style="color: #cca264;"></i>
                                        <span><strong>Bank Transfer</strong></span>
                                    </div>
                                </label>
                            </div>

                            <div class="form-check mb-3 p-3" style="border: 2px solid #e0e0e0; border-radius: 8px;">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal"
                                    value="paypal">
                                <label class="form-check-label w-100" for="paypal">
                                    <div class="d-flex align-items-center">
                                        <i class="fab fa-paypal me-3" style="color: #cca264;"></i>
                                        <span><strong>PayPal</strong></span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Card Details (shown when card is selected) -->
                        <div id="cardDetails" class="mt-4">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="cardNumber" class="form-label">Card Number *</label>
                                    <input type="text" class="form-control" id="cardNumber" name="card_number"
                                        placeholder="1234 5678 9012 3456" style="border-color: #e0e0e0;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expiryDate" class="form-label">Expiry Date *</label>
                                    <input type="text" class="form-control" id="expiryDate" name="expiry_date"
                                        placeholder="MM/YY" style="border-color: #e0e0e0;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cvv" class="form-label">CVV *</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123"
                                        style="border-color: #e0e0e0;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="cardName" class="form-label">Name on Card *</label>
                                <input type="text" class="form-control" id="cardName" name="card_name"
                                    style="border-color: #e0e0e0;">
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="" class="text-primary">Terms and Conditions</a>
                        </label>
                        @error('terms')
                        <div class="text-danger small mt-1">You must accept the terms and conditions</div>
                        @enderror
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="checkout-navigation d-flex justify-content-between">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary"
                            style="border-color: #101320; color: #101320;">
                            <i class="fas fa-arrow-left me-2"></i>BACK TO CART
                        </a>
                        <button type="submit" class="btn btn-outline-light">
                            PLACE ORDER<i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="order-summary p-4"
                        style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08); position: sticky; top: 120px;">
                        <h4 class="section-title mb-4">ORDER SUMMARY</h4>

                        <!-- Order Items -->
                        <div class="order-items mb-4">
                            @foreach($cart as $item)
                            <div class="order-item d-flex mb-3">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="me-3 rounded"
                                    style="width: 50px; height: 60px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item['name'] }}</h6>
                                    <small class="text-muted">Size: {{ $item['size'] }}, Qty: {{ $item['quantity']
                                        }}</small>
                                    <div class="text-end">₦ {{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr style="border-color: #e0e0e0;">

                        <div class="summary-row d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>₦ {{ number_format($subtotal, 2) }}</span>
                        </div>

                        <div class="summary-row d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span class="text-success" id="shippingCost">
                                @if($shipping == 0)
                                Free
                                @else
                                ₦ {{ number_format($shipping, 2) }}
                                @endif
                            </span>
                        </div>

                        <div class="summary-row d-flex justify-content-between mb-3">
                            <span>Tax (5%):</span>
                            <span>₦ {{ number_format($tax, 2) }}</span>
                        </div>

                        <hr style="border-color: #cca264;">

                        <div class="summary-row d-flex justify-content-between mb-4">
                            <strong>Total:</strong>
                            <strong id="orderTotal" style="color: #cca264; font-size: 1.2rem;">₦ {{
                                number_format($total, 2) }}</strong>
                        </div>

                        <!-- Security Badge -->
                        <div class="security-badge text-center">
                            <i class="fas fa-lock me-2" style="color: #cca264;"></i>
                            <small class="text-muted">Your payment information is secure and encrypted</small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Shipping method change handler
        const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
        const shippingCostEl = document.getElementById('shippingCost');
        const orderTotalEl = document.getElementById('orderTotal');
        const standardShippingCost = {{ $shipping }};
        const expressShippingCost = 15000;
        const subtotal = {{ $subtotal }};
        const tax = {{ $tax }};
        
        function updateShippingCost() {
            const selectedShipping = document.querySelector('input[name="shipping_method"]:checked').value;
            let shippingCost = 0;
            
            if (selectedShipping === 'standard') {
                shippingCost = standardShippingCost;
            } else if (selectedShipping === 'express') {
                shippingCost = expressShippingCost;
            }
            
            // Update shipping cost display
            shippingCostEl.textContent = shippingCost === 0 ? 'Free' : '₦ ' + shippingCost.toLocaleString('en-US', {minimumFractionDigits: 2});
            
            // Calculate new total
            const newTotal = subtotal + shippingCost + tax;
            orderTotalEl.textContent = '₦ ' + newTotal.toLocaleString('en-US', {minimumFractionDigits: 2});
        }
        
        shippingRadios.forEach(radio => {
            radio.addEventListener('change', updateShippingCost);
        });
        
        // Payment method change handler
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const cardDetails = document.getElementById('cardDetails');
        
        function toggleCardDetails() {
            const selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;
            cardDetails.style.display = selectedPayment === 'card' ? 'block' : 'none';
        }
        
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', toggleCardDetails);
        });
        
        // Initialize on page load
        toggleCardDetails();
    });
</script>


@include("home.footer")