@include("home.header")

<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Checkout Area Start ##### -->
<div class="checkout_area section-padding-80">
    <div class="container">
        @if($cartCount === 0)
        <div class="alert alert-warning text-center">
            <h4>Your cart is empty</h4>
            <p>Please add some items to your cart before proceeding to checkout.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
        @else
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="checkout_details_area mt-50 clearfix">
                    <div class="cart-page-heading mb-30">
                        <h5>Billing Address</h5>
                    </div>

                    <form action="{{ route('checkout.process') }}" method="post" id="checkoutForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name">First Name <span>*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                       value="{{ auth()->user() ? auth()->user()->first_name : old('first_name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">Last Name <span>*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                       value="{{ auth()->user() ? auth()->user()->last_name : old('last_name') }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="email_address">Email Address <span>*</span></label>
                                <input type="email" class="form-control" id="email_address" name="email"
                                       value="{{ auth()->user() ? auth()->user()->email : old('email') }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="phone_number">Phone No <span>*</span></label>
                                <input type="text" class="form-control" id="phone_number" name="phone"
                                       value="{{ auth()->user() ? auth()->user()->phone : old('phone') }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="country">Country <span>*</span></label>
                                <select class="w-100" id="country" name="country" required>
                                    <option value="">Select Country</option>
                                    <option value="Nigeria" {{ old('country') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                    <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                                    <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="street_address">Address <span>*</span></label>
                                <input type="text" class="form-control mb-3" id="street_address" name="address1"
                                       value="{{ old('address1') }}" placeholder="Street Address" required>
                                <input type="text" class="form-control" id="street_address2" name="address2"
                                       value="{{ old('address2') }}" placeholder="Apartment, suite, etc (optional)">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="city">Town/City <span>*</span></label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="state">State <span>*</span></label>
                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="postcode">Postcode/ZIP</label>
                                <input type="text" class="form-control" id="postcode" name="postcode" value="{{ old('postcode') }}">
                            </div>

                            <div class="col-12">
                                <div class="custom-control custom-checkbox d-block mb-2">
                                    <input type="checkbox" class="custom-control-input" id="terms" name="terms" required>
                                    <label class="custom-control-label" for="terms">I agree to the <a href="#">terms and conditions</a></label>
                                </div>
                                @guest
                                <div class="custom-control custom-checkbox d-block mb-2">
                                    <input type="checkbox" class="custom-control-input" id="create_account" name="create_account">
                                    <label class="custom-control-label" for="create_account">Create an account</label>
                                </div>
                                <div class="custom-control custom-checkbox d-block">
                                    <input type="checkbox" class="custom-control-input" id="subscribe" name="subscribe">
                                    <label class="custom-control-label" for="subscribe">Subscribe to our newsletter</label>
                                </div>
                                @endguest
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                <div class="order-details-confirmation">
                    <div class="cart-page-heading">
                        <h5>Your Order</h5>
                        <p>The Details</p>
                    </div>

                    <ul class="order-details-form mb-4">
                        <li><span>Product</span> <span>Total</span></li>
                        @foreach($cart as $item)
                        <li>
                            <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span> 
                            <span>₦{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </li>
                        @endforeach
                        <li><span>Subtotal</span> <span>₦{{ number_format($cartSubtotal, 2) }}</span></li>
                        <li><span>Shipping</span> <span>{{ $cartShipping === 0 ? 'FREE' : '₦'.number_format($cartShipping, 2) }}</span></li>
                        <li><span>Tax (5%)</span> <span>₦{{ number_format($cartTax, 2) }}</span></li>
                        <li><span>Total</span> <span>₦{{ number_format($cartTotal, 2) }}</span></li>
                    </ul>

                    <div id="accordion" role="tablist" class="mb-4">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne">
                                <h6 class="mb-0">
                                    <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <i class="fa fa-credit-card mr-3"></i>Credit/Debit Card
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="card_number">Card Number</label>
                                        <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="card_expiry">Expiry Date</label>
                                                <input type="text" class="form-control" id="card_expiry" name="card_expiry" placeholder="MM/YY">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="card_cvc">CVC</label>
                                                <input type="text" class="form-control" id="card_cvc" name="card_cvc" placeholder="123">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn essence-btn" onclick="processPayment('card')">Pay with Card</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingTwo">
                                <h6 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="fa fa-paypal mr-3"></i>PayPal
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    <p>You will be redirected to PayPal to complete your payment securely.</p>
                                    <button type="button" class="btn essence-btn" onclick="processPayment('paypal')">Pay with PayPal</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <h6 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <i class="fa fa-money mr-3"></i>Bank Transfer
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference.</p>
                                    <div class="bank-details">
                                        <p><strong>Bank Name:</strong> Example Bank</p>
                                        <p><strong>Account Name:</strong> Your Store Name</p>
                                        <p><strong>Account Number:</strong> 1234567890</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingFour">
                                <h6 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                        <i class="fa fa-truck mr-3"></i>Cash on Delivery
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseFour" class="collapse show" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Pay with cash when your order is delivered. Additional charges may apply.</p>
                                    <button type="button" class="btn essence-btn" onclick="processPayment('cod')">Place Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- ##### Checkout Area End ##### -->

@include("home.footer")

<script>
    $(document).ready(function() {
        // Auto-fill country if user has saved address
        @if(auth()->user() && auth()->user()->addresses()->count())
            var defaultAddress = @json(auth()->user()->addresses()->first());
            $('#country').val(defaultAddress.country);
            $('#street_address').val(defaultAddress.address_line1);
            $('#street_address2').val(defaultAddress.address_line2);
            $('#city').val(defaultAddress.city);
            $('#state').val(defaultAddress.state);
            $('#postcode').val(defaultAddress.postal_code);
        @endif
        
        // Initialize form validation
        $('#checkoutForm').validate({
            rules: {
                first_name: 'required',
                last_name: 'required',
                email: {
                    required: true,
                    email: true
                },
                phone: 'required',
                country: 'required',
                address1: 'required',
                city: 'required',
                state: 'required',
                terms: 'required'
            },
            messages: {
                terms: "Please accept our terms and conditions"
            }
        });
    });

    function processPayment(method) {
        if ($('#checkoutForm').valid()) {
            // Add payment method to form
            $('<input>').attr({
                type: 'hidden',
                name: 'payment_method',
                value: method
            }).appendTo('#checkoutForm');
            
            // Submit the form
            $('#checkoutForm').submit();
        } else {
            toastr.error('Please fill in all required fields correctly');
        }
    }
</script>