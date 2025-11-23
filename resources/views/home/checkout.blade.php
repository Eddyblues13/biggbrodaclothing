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
                            <div class="step {{ $currentStep >= 1 ? 'active' : '' }}">
                                <div class="step-number">1</div>
                                <div class="step-label">SHIPPING</div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="step {{ $currentStep >= 2 ? 'active' : '' }}">
                                <div class="step-number">2</div>
                                <div class="step-label">PAYMENT</div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="step {{ $currentStep >= 3 ? 'active' : '' }}">
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
                    @if($currentStep == 1)
                    <!-- Shipping Information -->
                    <div class="checkout-section-card mb-4">
                        <h4 class="section-title mb-4">SHIPPING INFORMATION</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required
                                    value="{{ old('first_name', $checkoutData['first_name'] ?? Auth::user()->first_name ?? '') }}" 
                                    style="border-color: #e0e0e0;">
                                @error('first_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required
                                    value="{{ old('last_name', $checkoutData['last_name'] ?? Auth::user()->last_name ?? '') }}" 
                                    style="border-color: #e0e0e0;">
                                @error('last_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="{{ old('email', $checkoutData['email'] ?? Auth::user()->email ?? '') }}" 
                                style="border-color: #e0e0e0;">
                            @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required
                                value="{{ old('phone', $checkoutData['phone'] ?? Auth::user()->phone ?? '') }}" 
                                style="border-color: #e0e0e0;">
                            @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address1" class="form-label">Street Address *</label>
                            <input type="text" class="form-control" id="address1" name="address1" required
                                value="{{ old('address1', $checkoutData['address1'] ?? '') }}" 
                                style="border-color: #e0e0e0;">
                            @error('address1')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address2" class="form-label">Address Line 2 (Optional)</label>
                            <input type="text" class="form-control" id="address2" name="address2"
                                value="{{ old('address2', $checkoutData['address2'] ?? '') }}" 
                                style="border-color: #e0e0e0;">
                            @error('address2')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="city" name="city" required
                                    value="{{ old('city', $checkoutData['city'] ?? '') }}" 
                                    style="border-color: #e0e0e0;">
                                @error('city')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="state" class="form-label">State *</label>
                                <select class="form-select" id="state" name="state" required
                                    style="border-color: #e0e0e0;">
                                    <option value="">Select State</option>
                                    <option value="lagos" {{ old('state', $checkoutData['state'] ?? '')=='lagos' ? 'selected' : '' }}>Lagos</option>
                                    <option value="abuja" {{ old('state', $checkoutData['state'] ?? '')=='abuja' ? 'selected' : '' }}>Abuja</option>
                                    <option value="kano" {{ old('state', $checkoutData['state'] ?? '')=='kano' ? 'selected' : '' }}>Kano</option>
                                    <option value="rivers" {{ old('state', $checkoutData['state'] ?? '')=='rivers' ? 'selected' : '' }}>Rivers</option>
                                    <option value="ogun" {{ old('state', $checkoutData['state'] ?? '')=='ogun' ? 'selected' : '' }}>Ogun</option>
                                </select>
                                @error('state')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="postcode" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="postcode" name="postcode"
                                    value="{{ old('postcode', $checkoutData['postcode'] ?? '') }}" 
                                    style="border-color: #e0e0e0;">
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
                                    value="standard" {{ old('shipping_method', $checkoutData['shipping_method'] ?? 'standard') == 'standard' ? 'checked' : '' }}>
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
                                    value="express" {{ old('shipping_method', $checkoutData['shipping_method'] ?? '') == 'express' ? 'checked' : '' }}>
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

                    @elseif($currentStep == 2)
                    <!-- Payment Method -->
                    <div class="checkout-section-card mb-4">
                        <h4 class="section-title mb-4">PAYMENT METHOD</h4>

                        <div class="payment-options">
                            <div class="form-check mb-3 p-3" style="border: 2px solid #e0e0e0; border-radius: 8px;">
                                <input class="form-check-input" type="radio" name="payment_method" id="card"
                                    value="card" {{ old('payment_method', $checkoutData['payment_method'] ?? 'card') == 'card' ? 'checked' : '' }}>
                                <label class="form-check-label w-100" for="card">
                                    <div class="d-flex align-items-center">
                                        <i class="fab fa-cc-visa me-3" style="color: #cca264; font-size: 1.5rem;"></i>
                                        <span><strong>Credit/Debit Card (Flutterwave)</strong></span>
                                    </div>
                                </label>
                            </div>

                            <div class="form-check mb-3 p-3" style="border: 2px solid #e0e0e0; border-radius: 8px;">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer"
                                    value="bank_transfer" {{ old('payment_method', $checkoutData['payment_method'] ?? '') == 'bank_transfer' ? 'checked' : '' }}>
                                <label class="form-check-label w-100" for="bank_transfer">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-university me-3" style="color: #cca264; font-size: 1.5rem;"></i>
                                        <span><strong>Bank Transfer</strong></span>
                                    </div>
                                </label>
                            </div>

                            <div class="form-check mb-3 p-3" style="border: 2px solid #e0e0e0; border-radius: 8px;">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal"
                                    value="paypal" {{ old('payment_method', $checkoutData['payment_method'] ?? '') == 'paypal' ? 'checked' : '' }}>
                                <label class="form-check-label w-100" for="paypal">
                                    <div class="d-flex align-items-center">
                                        <i class="fab fa-paypal me-3" style="color: #cca264; font-size: 1.5rem;"></i>
                                        <span><strong>PayPal</strong></span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Method Instructions -->
                        <div id="paymentInstructions" class="mt-4 p-3 bg-light rounded">
                            <div id="cardInstructions" class="payment-instruction">
                                <h6><i class="fab fa-cc-visa me-2"></i>Secure Card Payment</h6>
                                <p class="mb-2">You will be redirected to Flutterwave's secure payment page to complete your transaction.</p>
                                <small class="text-muted">We accept Visa, Mastercard, and Verve cards</small>
                            </div>
                            <div id="bankInstructions" class="payment-instruction d-none">
                                <h6><i class="fas fa-university me-2"></i>Bank Transfer</h6>
                                <p class="mb-2">Make payment to our bank account and upload proof of payment.</p>
                                <small class="text-muted">Account details will be provided after order confirmation</small>
                            </div>
                            <div id="paypalInstructions" class="payment-instruction d-none">
                                <h6><i class="fab fa-paypal me-2"></i>PayPal</h6>
                                <p class="mb-2">You will be redirected to PayPal to complete your payment.</p>
                                <small class="text-muted">International cards accepted</small>
                            </div>
                        </div>
                    </div>

                    @elseif($currentStep == 3)
                    <!-- Review Order -->
                    <div class="checkout-section-card mb-4">
                        <h4 class="section-title mb-4">REVIEW YOUR ORDER</h4>

                        <!-- Shipping Information Review -->
                        <div class="review-section mb-4">
                            <h6 class="mb-3">Shipping Information</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-1"><strong>{{ $checkoutData['first_name'] }} {{ $checkoutData['last_name'] }}</strong></p>
                                <p class="mb-1">{{ $checkoutData['address1'] }}</p>
                                @if(!empty($checkoutData['address2']))
                                <p class="mb-1">{{ $checkoutData['address2'] }}</p>
                                @endif
                                <p class="mb-1">{{ $checkoutData['city'] }}, {{ $checkoutData['state'] }} {{ $checkoutData['postcode'] ?? '' }}</p>
                                <p class="mb-1">Nigeria</p>
                                <p class="mb-1">Phone: {{ $checkoutData['phone'] }}</p>
                                <p class="mb-0">Email: {{ $checkoutData['email'] }}</p>
                            </div>
                        </div>

                        <!-- Shipping Method Review -->
                        <div class="review-section mb-4">
                            <h6 class="mb-3">Shipping Method</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0">
                                    <strong>{{ ucfirst($checkoutData['shipping_method']) }} Delivery</strong> - 
                                    {{ $checkoutData['shipping_method'] == 'express' ? '1-2 business days' : '3-5 business days' }}
                                </p>
                            </div>
                        </div>

                        <!-- Payment Method Review -->
                        <div class="review-section mb-4">
                            <h6 class="mb-3">Payment Method</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0">
                                    <strong>
                                        @if($checkoutData['payment_method'] == 'card')
                                        Credit/Debit Card (Flutterwave)
                                        @elseif($checkoutData['payment_method'] == 'bank_transfer')
                                        Bank Transfer
                                        @else
                                        PayPal
                                        @endif
                                    </strong>
                                </p>
                            </div>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and confirm that all information provided is accurate.
                            </label>
                            @error('terms')
                            <div class="text-danger small mt-1">You must accept the terms and conditions</div>
                            @enderror
                        </div>
                    </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="checkout-navigation d-flex justify-content-between">
                        @if($currentStep > 1)
                        <a href="{{ route('checkout.index', ['step' => $currentStep - 1]) }}" class="btn btn-outline-secondary"
                            style="border-color: #101320; color: #101320;">
                            <i class="fas fa-arrow-left me-2"></i>BACK
                        </a>
                        @else
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary"
                            style="border-color: #101320; color: #101320;">
                            <i class="fas fa-arrow-left me-2"></i>BACK TO CART
                        </a>
                        @endif

                        @if($currentStep < 3)
                        <button type="submit" formaction="{{ route('checkout.save-step', $currentStep) }}" 
                            class="btn btn-outline-light">
                            CONTINUE<i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        @else
                        <button type="submit" class="btn btn-outline-light" id="placeOrderBtn">
                            <i class="fas fa-lock me-2"></i>PLACE ORDER & PAY
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="order-summary p-4"
                        style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08); position: sticky; top: 120px;">
                        <h4 class="section-title mb-4">ORDER SUMMARY</h4>

                        <!-- Order Items -->
                        <div class="order-items mb-4" style="max-height: 300px; overflow-y: auto;">
                            @foreach($cart as $item)
                            <div class="order-item d-flex mb-3">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="me-3 rounded"
                                    style="width: 50px; height: 60px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item['name'] }}</h6>
                                    <small class="text-muted">
                                        Size: {{ $item['size'] ?? 'N/A' }}, Qty: {{ $item['quantity'] }}
                                    </small>
                                    <div class="text-end">₦ {{ number_format($item['price'] * $item['quantity'], 2) }}</div>
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
                        <div class="security-badge text-center p-3 bg-light rounded">
                            <i class="fas fa-lock me-2" style="color: #cca264;"></i>
                            <small class="text-muted">Your payment information is secure and encrypted</small>
                        </div>

                        <!-- Flutterwave Security Badge -->
                        <div class="text-center mt-3">
                            <img src="https://flutterwave.com/images/logo/full.svg" alt="Flutterwave" style="height: 30px; opacity: 0.7;">
                            <small class="d-block text-muted mt-1">PCI DSS Compliant</small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<style>
    .checkout-progress .step {
        position: relative;
    }

    .checkout-progress .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e0e0e0;
        color: #666;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-weight: bold;
    }

    .checkout-progress .step.active .step-number {
        background: #cca264;
        color: white;
    }

    .checkout-progress .step-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #666;
    }

    .checkout-progress .step.active .step-label {
        color: #cca264;
    }

    .checkout-section-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08);
        margin-bottom: 1.5rem;
    }

    .payment-instruction {
        transition: all 0.3s ease;
    }

    .btn-outline-light {
        border-color: #cca264;
        color: #cca264;
        background: transparent;
    }

    .btn-outline-light:hover {
        background: #cca264;
        color: white;
        border-color: #cca264;
    }

    .review-section {
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 1rem;
    }

    .review-section:last-child {
        border-bottom: none;
    }
</style>

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
        const paymentInstructions = document.querySelectorAll('.payment-instruction');
        
        function togglePaymentInstructions() {
            const selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;
            
            // Hide all instructions first
            paymentInstructions.forEach(instruction => {
                instruction.classList.add('d-none');
            });
            
            // Show selected payment instruction
            const selectedInstruction = document.getElementById(selectedPayment + 'Instructions');
            if (selectedInstruction) {
                selectedInstruction.classList.remove('d-none');
            }
        }
        
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', togglePaymentInstructions);
        });
        
        // Initialize on page load
        togglePaymentInstructions();

        // Form submission for final step
        const checkoutForm = document.getElementById('checkoutForm');
        const placeOrderBtn = document.getElementById('placeOrderBtn');
        
        if (checkoutForm && placeOrderBtn) {
            checkoutForm.addEventListener('submit', async function(e) {
                if ({{ $currentStep }} === 3) {
                    e.preventDefault();
                    
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    
                    try {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> PROCESSING ORDER...';
                        
                        const formData = new FormData(this);
                        
                        const response = await fetch('{{ route("checkout.process") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            // Redirect to Flutterwave payment page
                            window.location.href = data.payment_url;
                        } else {
                            throw new Error(data.message);
                        }
                    } catch (error) {
                        console.error('Checkout error:', error);
                        toastr.error(error.message || 'Failed to process checkout');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                }
            });
        }

        // Toastr initialization
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 5000,
            extendedTimeOut: 2000,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
    });
</script>

@include("home.footer")