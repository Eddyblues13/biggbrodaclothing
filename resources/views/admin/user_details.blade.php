@include('admin.header')
<style>
    .user-profile-card {
        border-left: 4px solid #007bff;
    }
    .user-orders-card {
        border-left: 4px solid #28a745;
    }
    .user-addresses-card {
        border-left: 4px solid #ffc107;
    }
    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #007bff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.5rem;
    }
    .stats-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
    }
</style>

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="title1 text-dark">User Details</h1>
                    <p class="text-muted">User ID: {{ $user->id }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Users
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
                <!-- User Profile -->
                <div class="col-md-4">
                    <div class="card user-profile-card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">User Profile</h4>
                        </div>
                        <div class="card-body text-center">
                            <div class="user-avatar-large mx-auto mb-3">
                                {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                            </div>
                            <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="stats-card">
                                        <h5 class="mb-1">{{ $user->orders_count }}</h5>
                                        <small class="text-muted">Orders</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card">
                                        <h5 class="mb-1">{{ $user->addresses->count() }}</h5>
                                        <small class="text-muted">Addresses</small>
                                    </div>
                                </div>
                            </div>

                            <div class="user-info text-left">
                                <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                                <p><strong>Email Status:</strong> 
                                    @if($user->email_verified_at)
                                    <span class="badge badge-success">Verified</span>
                                    @else
                                    <span class="badge badge-warning">Unverified</span>
                                    @endif
                                </p>
                                <p><strong>Member Since:</strong> {{ $user->created_at->format('F d, Y') }}</p>
                                <p><strong>Last Updated:</strong> {{ $user->updated_at->format('F d, Y') }}</p>
                            </div>

                            <div class="user-actions mt-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit User
                                </a>
                                <form action="{{ route('admin.users.toggle-verification', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $user->email_verified_at ? 'warning' : 'success' }} btn-sm">
                                        <i class="fas fa-{{ $user->email_verified_at ? 'times' : 'check' }}"></i> 
                                        {{ $user->email_verified_at ? 'Unverify' : 'Verify' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="col-md-8">
                    <div class="card user-orders-card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Recent Orders</h4>
                            <span class="badge badge-primary">{{ $user->orders_count }} total orders</span>
                        </div>
                        <div class="card-body">
                            @if($user->orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->orders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary">
                                                    #{{ $order->order_number }}
                                                </a>
                                            </td>
                                            <td>{{ $order->order_date->format('M d, Y') }}</td>
                                            <td>${{ number_format($order->total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge badge-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'warning' : 'primary') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No orders found for this user.</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- User Addresses -->
                    <div class="card user-addresses-card">
                        <div class="card-header">
                            <h4 class="card-title">Saved Addresses</h4>
                        </div>
                        <div class="card-body">
                            @if($user->addresses->count() > 0)
                            <div class="row">
                                @foreach($user->addresses as $address)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                {{ $address->address_type ?? 'Address' }}
                                                @if($address->is_default)
                                                <span class="badge badge-success ml-2">Default</span>
                                                @endif
                                            </h6>
                                            <p class="card-text mb-1">{{ $address->address_line_1 }}</p>
                                            @if($address->address_line_2)
                                            <p class="card-text mb-1">{{ $address->address_line_2 }}</p>
                                            @endif
                                            <p class="card-text mb-1">
                                                {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                            </p>
                                            <p class="card-text">{{ $address->country }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No addresses saved for this user.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')