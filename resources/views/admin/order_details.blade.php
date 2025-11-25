@include('admin.header')
<style>
    .order-details-card {
        border-left: 4px solid #007bff;
    }
    .customer-info-card {
        border-left: 4px solid #28a745;
    }
    .order-items-card {
        border-left: 4px solid #ffc107;
    }
    .order-timeline {
        border-left: 3px solid #007bff;
        padding-left: 20px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -26px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #007bff;
    }
    .order-status-badge {
        font-size: 0.8rem;
        padding: 5px 10px;
    }
</style>

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="title1 text-dark">Order Details</h1>
                    <p class="text-muted">Order #{{ $order->order_number }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="row">
                <!-- Order Summary -->
                <div class="col-md-8">
                    <div class="card order-details-card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Order Summary</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Order Number:</strong> {{ $order->order_number }}<br>
                                    <strong>Order Date:</strong> {{ $order->order_date->format('F d, Y \a\t h:i A') }}<br>
                                    <strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}<br>
                                    <strong>Shipping Method:</strong> {{ ucfirst($order->shipping_method) }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Order Status:</strong>
                                    <span class="order-status-badge badge 
                                        @if($order->status == 'pending') badge-warning
                                        @elseif($order->status == 'processing') badge-primary
                                        @elseif($order->status == 'shipped') badge-info
                                        @elseif($order->status == 'delivered') badge-success
                                        @else badge-danger @endif">
                                        {{ ucfirst($order->status) }}
                                    </span><br>
                                    <strong>Payment Status:</strong>
                                    <span class="order-status-badge badge 
                                        @if($order->payment_status == 'pending') badge-warning
                                        @elseif($order->payment_status == 'paid') badge-success
                                        @elseif($order->payment_status == 'failed') badge-danger
                                        @else badge-secondary @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span><br>
                                    @if($order->transaction_id)
                                    <strong>Transaction ID:</strong> {{ $order->transaction_id }}
                                    @endif
                                </div>
                            </div>

                            <!-- Order Actions -->
                            @if($order->status == 'pending')
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="btn-group">
                                        <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i> Approve Order
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.orders.decline', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-times"></i> Decline Order
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Status Update Form -->
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="status">Update Order Status</label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="payment_status">Update Payment Status</label>
                                                <select class="form-control" name="payment_status" id="payment_status">
                                                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card order-items-card">
                        <div class="card-header">
                            <h4 class="card-title">Order Items ({{ $order->orderItems->count() }})</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product_image)
                                                    <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" 
                                                         class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @endif
                                                    <div class="ml-3">
                                                        <strong>{{ $item->product_name }}</strong>
                                                        @if($item->size || $item->color)
                                                        <br>
                                                        <small class="text-muted">
                                                            @if($item->size) Size: {{ $item->size }} @endif
                                                            @if($item->size && $item->color) | @endif
                                                            @if($item->color) Color: {{ $item->color }} @endif
                                                        </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                                            <td><strong>${{ number_format($order->subtotal, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Shipping:</strong></td>
                                            <td><strong>${{ number_format($order->shipping_cost, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Tax:</strong></td>
                                            <td><strong>${{ number_format($order->tax_amount, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                            <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information & Timeline -->
                <div class="col-md-4">
                    <!-- Customer Information -->
                    <div class="card customer-info-card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Customer Information</h4>
                        </div>
                        <div class="card-body">
                            <strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}<br>
                            <strong>Email:</strong> {{ $order->email }}<br>
                            <strong>Phone:</strong> {{ $order->phone }}<br>
                            @if($order->user)
                            <strong>Account:</strong> 
                            <a href="{{ route('admin.users.show', $order->user->id) }}">
                                {{ $order->user->first_name }} {{ $order->user->last_name }}
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Shipping Address</h4>
                        </div>
                        <div class="card-body">
                            {{ $order->address1 }}<br>
                            @if($order->address2){{ $order->address2 }}<br>@endif
                            {{ $order->city }}, {{ $order->state }}<br>
                            @if($order->postcode){{ $order->postcode }}<br>@endif
                            {{ $order->country }}
                        </div>
                    </div>

                    <!-- Order Timeline -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Order Timeline</h4>
                        </div>
                        <div class="card-body">
                            <div class="order-timeline">
                                <div class="timeline-item">
                                    <strong>Order Placed</strong><br>
                                    <small class="text-muted">{{ $order->order_date->format('M d, Y \a\t h:i A') }}</small>
                                </div>
                                @if($order->paid_at)
                                <div class="timeline-item">
                                    <strong>Payment Received</strong><br>
                                    <small class="text-muted">{{ $order->paid_at->format('M d, Y \a\t h:i A') }}</small>
                                </div>
                                @endif
                                @if($order->shipped_at)
                                <div class="timeline-item">
                                    <strong>Order Shipped</strong><br>
                                    <small class="text-muted">{{ $order->shipped_at->format('M d, Y \a\t h:i A') }}</small>
                                </div>
                                @endif
                                @if($order->delivered_at)
                                <div class="timeline-item">
                                    <strong>Order Delivered</strong><br>
                                    <small class="text-muted">{{ $order->delivered_at->format('M d, Y \a\t h:i A') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')