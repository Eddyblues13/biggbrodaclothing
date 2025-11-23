 @include("home.header")
    <style>
        .order-details-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding-top: 120px;
        }

        .order-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08);
            padding: 2rem;
        }

        .order-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }

        .order-item {
            border-bottom: 1px solid #e9ecef;
            padding: 1.5rem 0;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .badge {
            background: #cca264;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .btn-outline-light {
            border-color: #cca264;
            color: #cca264;
            background: transparent;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background: #cca264;
            color: white;
            transform: translateY(-2px);
        }

        .summary-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
        }

        .section-title {
            color: #101320;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .status-timeline {
            position: relative;
            padding-left: 2rem;
        }

        .status-timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .status-step {
            position: relative;
            margin-bottom: 2rem;
        }

        .status-step::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #dee2e6;
            border: 2px solid white;
        }

        .status-step.active::before {
            background: #cca264;
            border-color: #cca264;
        }

        .status-step.completed::before {
            background: #28a745;
            border-color: #28a745;
        }

        /* ------------------ MOBILE RESPONSIVE FIXES ------------------ */
        @media (max-width: 768px) {

            .order-details-section {
                padding-top: 60px;
            }

            .order-container {
                padding: 1rem;
            }

            .order-header h1 {
                font-size: 1.4rem;
            }

            .order-header .badge {
                font-size: 0.7rem;
                padding: 0.3rem 0.7rem;
            }

            .order-header .text-end {
                text-align: center !important;
                margin-top: 10px;
            }

            /* Stack order items neatly */
            .order-item .row {
                text-align: center;
            }

            .product-image {
                width: 70px;
                height: 70px;
                margin-bottom: 10px;
            }

            .summary-card {
                padding: 1rem;
            }

            .status-step {
                margin-bottom: 1.5rem;
            }

            .status-step::before {
                left: -1.5rem;
            }
        }

        /* Status icons responsive */
        .status-step i {
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .status-step i {
                font-size: 0.85rem;
            }
        }
    </style>

</head>


   

    <section class="order-details-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="order-container">

                        <!-- Order Header -->
                        <div class="order-header">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">

                                <div>
                                    <h1 class="section-title mb-2">ORDER #{{ $order->order_number }}</h1>
                                    <p class="text-muted mb-1">
                                        Placed on {{ $order->order_date->format('F d, Y \\a\\t h:i A') }}
                                    </p>

                                    <div class="d-flex gap-3 mt-2 flex-wrap">
                                        <span class="badge"
                                            style="background: {{ $order->status === 'delivered' ? '#28a745' : 
                                                ($order->status === 'processing' ? '#007bff' : 
                                                ($order->status === 'pending' ? '#ffc107' : 
                                                ($order->status === 'cancelled' ? '#dc3545' : '#6c757d'))) }}; 
                                                color: white;">
                                            Status: {{ ucfirst($order->status) }}
                                        </span>

                                        <span class="badge"
                                            style="background: {{ $order->payment_status === 'paid' ? '#28a745' : '#dc3545' }};">
                                            Payment: {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="text-end text-md-end text-center mt-3 mt-md-0">
                                    <a href="{{ route('profile') }}" class="btn btn-outline-light">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Orders
                                    </a>
<!-- 
                                    @if($order->canBeCancelled())
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger mt-2 mt-md-0"
                                            onclick="return confirm('Are you sure you want to cancel this order?')">
                                            <i class="fas fa-times me-1"></i>Cancel Order
                                        </button>
                                    </form>
                                    @endif -->
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <!-- Order Items -->
                            <div class="col-lg-8">
                                <h4 class="mb-4">ORDER ITEMS</h4>

                                @foreach($order->orderItems as $item)
                                <div class="order-item">
                                    <div class="row align-items-center gy-3">

                                        <div class="col-md-2">
                                            <img src="{{ $item->product_image ?? '/images/placeholder.jpg' }}"
                                                alt="{{ $item->product_name }}" class="product-image">
                                        </div>

                                        <div class="col-md-5">
                                            <h6 class="mb-1">{{ $item->product_name }}</h6>
                                            <p class="text-muted mb-1">SKU: {{ $item->product_id }}</p>
                                            @if($item->size)
                                            <small class="text-muted">Size: {{ $item->size }}</small><br>
                                            @endif
                                            @if($item->color)
                                            <small class="text-muted">Color: {{ $item->color }}</small>
                                            @endif
                                        </div>

                                        <div class="col-md-2 text-center">
                                            <p class="mb-0">Qty: {{ $item->quantity }}</p>
                                        </div>

                                        <div class="col-md-3 text-end">
                                            <p class="mb-0 fw-bold">₦ {{ number_format($item->price * $item->quantity, 2) }}</p>
                                            <small class="text-muted">₦ {{ number_format($item->price, 2) }} each</small>
                                        </div>

                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Summary & Tracking -->
                            <div class="col-lg-4">

                                <!-- Tracking -->
                                <div class="summary-card mb-4">
                                    <h5 class="mb-4">ORDER TRACKING</h5>

                                    <div class="status-timeline">
                                        @php
                                        $statuses = [
                                            'pending' => ['icon' => 'fas fa-clock', 'label' => 'Order Placed', 'description' => 'Your order has been received'],
                                            'processing' => ['icon' => 'fas fa-cog', 'label' => 'Processing', 'description' => 'We\'re preparing your order'],
                                            'shipped' => ['icon' => 'fas fa-shipping-fast', 'label' => 'Shipped', 'description' => 'Your order is on the way'],
                                            'delivered' => ['icon' => 'fas fa-check-circle', 'label' => 'Delivered', 'description' => 'Order delivered successfully'],
                                        ];

                                        $currentStatus = $order->status;
                                        @endphp

                                        @foreach($statuses as $status => $info)
                                        @php
                                        $isCompleted = array_search($currentStatus, array_keys($statuses)) >= array_search($status, array_keys($statuses));
                                        $isActive = $currentStatus === $status;
                                        @endphp

                                        <div class="status-step {{ $isCompleted ? 'completed' : '' }} {{ $isActive ? 'active' : '' }}">
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="{{ $info['icon'] }} me-2 {{ $isCompleted ? 'text-success' : ($isActive ? 'text-warning' : 'text-muted') }}"></i>
                                                <strong class="{{ $isCompleted ? 'text-success' : ($isActive ? 'text-warning' : 'text-muted') }}">
                                                    {{ $info['label'] }}
                                                </strong>
                                            </div>

                                            <p class="text-muted small mb-0">{{ $info['description'] }}</p>

                                            @if($isActive && $order->shipped_at)
                                            <small class="text-muted">Shipped on: {{ $order->shipped_at->format('M d, Y') }}</small>
                                            @endif

                                            @if($isActive && $order->delivered_at)
                                            <small class="text-muted">Delivered on: {{ $order->delivered_at->format('M d, Y') }}</small>
                                            @endif
                                        </div>
                                        @endforeach

                                    </div>
                                </div>

                                <!-- Order Summary -->
                                <div class="summary-card">
                                    <h5 class="mb-4">ORDER SUMMARY</h5>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>₦ {{ number_format($order->subtotal, 2) }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Shipping:</span>
                                        <span>₦ {{ number_format($order->shipping_cost, 2) }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tax:</span>
                                        <span>₦ {{ number_format($order->tax_amount, 2) }}</span>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between mb-3 fw-bold">
                                        <span>Total:</span>
                                        <span>₦ {{ number_format($order->total_amount, 2) }}</span>
                                    </div>

                                    <h6 class="mb-3 mt-4">SHIPPING ADDRESS</h6>
                                    <p class="mb-1">{{ $order->first_name }} {{ $order->last_name }}</p>
                                    <p class="mb-1">{{ $order->address1 }}</p>
                                    @if($order->address2)
                                    <p class="mb-1">{{ $order->address2 }}</p>
                                    @endif
                                    <p class="mb-1">{{ $order->city }}, {{ $order->state }} {{ $order->postcode }}</p>
                                    <p class="mb-1">{{ $order->country }}</p>
                                    <p class="mb-0">{{ $order->phone }}</p>

                                    <h6 class="mb-3 mt-4">SHIPPING METHOD</h6>
                                    <p class="mb-0">{{ ucfirst($order->shipping_method) }}</p>

                                    <h6 class="mb-3 mt-4">PAYMENT METHOD</h6>
                                    <p class="mb-0">{{ ucfirst($order->payment_method) }}</p>
                                    @if($order->transaction_id)
                                    <small class="text-muted">Transaction ID: {{ $order->transaction_id }}</small>
                                    @endif

                                    <h6 class="mb-3 mt-4">IMPORTANT DATES</h6>
                                    <p class="mb-1 small">
                                        <strong>Order Date:</strong> {{ $order->order_date->format('M d, Y') }}
                                    </p>

                                    @if($order->paid_at)
                                    <p class="mb-1 small">
                                        <strong>Paid On:</strong> {{ $order->paid_at->format('M d, Y') }}
                                    </p>
                                    @endif

                                    @if($order->shipped_at)
                                    <p class="mb-1 small">
                                        <strong>Shipped On:</strong> {{ $order->shipped_at->format('M d, Y') }}
                                    </p>
                                    @endif

                                    @if($order->delivered_at)
                                    <p class="mb-1 small">
                                        <strong>Delivered On:</strong> {{ $order->delivered_at->format('M d, Y') }}
                                    </p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <!-- Order Actions -->
                        @if($order->canBeCancelled())
                        <div class="mt-4 pt-4 border-top">
                            <h5 class="mb-3">ORDER ACTIONS</h5>
                            <div class="d-flex flex-wrap gap-2">

                                <!-- <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to cancel this order? This action cannot be undone.')">
                                        <i class="fas fa-times me-1"></i>Cancel Order
                                    </button>
                                </form> -->

                                <a href="{{ route('shop') }}" class="btn btn-outline-light">
                                    <i class="fas fa-shopping-bag me-1"></i>Continue Shopping
                                </a>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include("home.footer")

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        @if(session('success'))
            alert('{{ session('success') }}');
        @endif

        @if(session('error'))
            alert('{{ session('error') }}');
        @endif

        function printOrder() {
            window.print();
        }
    </script>

</body>

</html>
