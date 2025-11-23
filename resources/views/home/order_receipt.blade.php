@include("home.header")

<section class="receipt-section py-5" style="margin-top: 100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="receipt-card bg-white rounded p-4 shadow">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="text-center mb-4">
                        <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                        <h1 class="section-title">Order Confirmed!</h1>
                        <p class="text-muted">Thank you for your purchase</p>
                    </div>

                    <div class="order-details mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Order Information</h5>
                                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                <p><strong>Order Date:</strong> {{ $order->order_date->format('F d, Y') }}</p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-{{ $order->isProcessing() ? 'warning' : 'success' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5>Payment Information</h5>
                                <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                                <p><strong>Payment Status:</strong> 
                                    <span class="badge bg-{{ $order->isPaid() ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </p>
                                @if($order->transaction_id)
                                <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="order-items mb-4">
                        <h5>Order Items</h5>
                        @foreach($order->orderItems as $item)
                        <div class="order-item d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <span class="me-3">{{ $item->product_name }}</span>
                                @if($item->size)
                                <small class="text-muted">Size: {{ $item->size }}</small>
                                @endif
                            </div>
                            <div>
                                <span>₦ {{ number_format($item->price, 2) }} x {{ $item->quantity }}</span>
                                <strong class="ms-2">₦ {{ number_format($item->price * $item->quantity, 2) }}</strong>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="order-summary">
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="summary-row d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>₦ {{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="summary-row d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span>₦ {{ number_format($order->shipping_cost, 2) }}</span>
                                </div>
                                <div class="summary-row d-flex justify-content-between mb-2">
                                    <span>Tax:</span>
                                    <span>₦ {{ number_format($order->tax_amount, 2) }}</span>
                                </div>
                                <hr>
                                <div class="summary-row d-flex justify-content-between mb-4">
                                    <strong>Total:</strong>
                                    <strong style="color: #cca264; font-size: 1.2rem;">
                                        ₦ {{ number_format($order->total_amount, 2) }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="shipping-info mb-4">
                        <h5>Shipping Address</h5>
                        <p>
                            {{ $order->first_name }} {{ $order->last_name }}<br>
                            {{ $order->address1 }}<br>
                            @if($order->address2){{ $order->address2 }}<br>@endif
                            {{ $order->city }}, {{ $order->state }} {{ $order->postcode }}<br>
                            {{ $order->country }}<br>
                            Phone: {{ $order->phone }}<br>
                            Email: {{ $order->email }}
                        </p>
                    </div>

                    <div class="action-buttons text-center">
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                        <a href="{{ route('profile') }}" class="btn btn-outline-light">
                            <i class="fas fa-history me-2"></i>Order History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include("home.footer")