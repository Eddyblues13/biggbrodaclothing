 @include("home.header")
    <style>
        /* Dashboard Specific Styles */
        .dashboard-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .welcome-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08);
            border-left: 4px solid #cca264;
        }

        .dashboard-sidebar {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08);
            height: fit-content;
            position: sticky;
            top: 120px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .sidebar-item {
            padding: 1rem 1.5rem;
            color: #101320;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .sidebar-item:hover {
            background: #f8f9fa;
            color: #cca264;
            transform: translateX(5px);
        }

        .sidebar-item.active {
            background: #cca264;
            color: white;
        }

        .sidebar-item i {
            width: 20px;
            margin-right: 10px;
        }

        .dashboard-content {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08);
            padding: 2rem;
            min-height: 500px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(16, 19, 32, 0.08);
            border-top: 4px solid #cca264;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(16, 19, 32, 0.15);
        }

        .stat-card i {
            font-size: 2rem;
            color: #cca264;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #101320;
            margin: 0.5rem 0;
        }

        .stat-card p {
            color: #666;
            margin: 0;
            font-weight: 500;
        }

        .order-card, .address-card {
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #cca264;
            transition: all 0.3s ease;
        }

        .order-card:hover, .address-card:hover {
            background: white;
            box-shadow: 0 4px 15px rgba(16, 19, 32, 0.1);
            transform: translateY(-2px);
        }

        .profile-form .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.75rem;
        }

        .profile-form .form-control:focus {
            border-color: #cca264;
            box-shadow: 0 0 0 0.2rem rgba(204, 162, 100, 0.25);
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
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background: #cca264;
            color: white;
            transform: translateY(-2px);
        }

        .recent-orders, .order-item {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .recent-orders:last-child, .order-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-sidebar {
                position: static;
                margin-bottom: 2rem;
            }

            .sidebar-menu {
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 1rem;
            }

            .sidebar-item {
                white-space: nowrap;
                flex: 0 0 auto;
            }

            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>




    <!-- Dashboard Content -->
    <section class="dashboard-section py-5" style="margin-top: 100px;">
        <div class="container">
            <!-- Welcome Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="welcome-card p-4">
                        <h1 class="section-title mb-2">WELCOME BACK, {{ strtoupper($user->first_name) }}</h1>
                        <p style="color: #666;">Manage your account and track your orders</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="dashboard-sidebar p-3">
                        <div class="sidebar-menu">
                            <a href="#" class="sidebar-item active" onclick="showSection('overview')">
                                <i class="fas fa-tachometer-alt me-2"></i>Overview
                            </a>
                            <a href="#" class="sidebar-item" onclick="showSection('orders')">
                                <i class="fas fa-shopping-bag me-2"></i>My Orders
                            </a>
                            <a href="#" class="sidebar-item" onclick="showSection('profile')">
                                <i class="fas fa-user me-2"></i>Profile
                            </a>
                            <a href="#" class="sidebar-item" onclick="showSection('addresses')">
                                <i class="fas fa-map-marker-alt me-2"></i>Addresses
                            </a>
                            <a href="#" class="sidebar-item" onclick="showSection('wishlist')">
                                <i class="fas fa-heart me-2"></i>Wishlist
                            </a>
                            <a href="#" class="sidebar-item text-danger" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Overview Section -->
                    <div id="overview" class="dashboard-content">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <div class="stat-card p-3 text-center">
                                    <i class="fas fa-shopping-bag mb-2"></i>
                                    <h3>{{ $totalOrders }}</h3>
                                    <p class="mb-0">Total Orders</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="stat-card p-3 text-center">
                                    <i class="fas fa-clock mb-2"></i>
                                    <h3>{{ $pendingOrders }}</h3>
                                    <p class="mb-0">Pending Orders</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="stat-card p-3 text-center">
                                    <i class="fas fa-check-circle mb-2"></i>
                                    <h3>{{ $completedOrders }}</h3>
                                    <p class="mb-0">Completed Orders</p>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Orders -->
                        <div class="recent-orders">
                            <h4 class="section-title mb-3">RECENT ORDERS</h4>
                            @if($recentOrders->count() > 0)
                                @foreach($recentOrders as $order)
                                <div class="order-card p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6>#{{ $order->order_number }}</h6>
                                            <p class="mb-0">{{ $order->order_date->format('F d, Y') }}</p>
                                        </div>
                                        <div class="text-end">
                                            <p class="mb-0">₦ {{ number_format($order->total_amount, 2) }}</p>
                                            <span class="badge"
                                                style="background: {{ $order->status === 'delivered' ? '#28a745' : 
                                                                    ($order->status === 'processing' ? '#007bff' : 
                                                                    ($order->status === 'pending' ? '#ffc107' : 
                                                                    ($order->status === 'cancelled' ? '#dc3545' : '#6c757d'))) }}; 
                                                        color: white;">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No orders yet</p>
                                    <a href="{{ route('shop') }}" class="btn btn-outline-light">Start Shopping</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Orders Section -->
                    <div id="orders" class="dashboard-content" style="display: none;">
                        <h4 class="section-title mb-4">MY ORDERS</h4>
                        @if($user->orders->count() > 0)
                            @foreach($user->orders as $order)
                            <div class="order-item p-4 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <h6>#{{ $order->order_number }}</h6>
                                        <p class="mb-0">{{ $order->order_date->format('F d, Y') }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="mb-0">{{ $order->orderItems->count() }} Items</p>
                                        <p class="mb-0">₦ {{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <span class="badge"
                                            style="background: {{ $order->status === 'delivered' ? '#28a745' : 
                                                                ($order->status === 'processing' ? '#007bff' : 
                                                                ($order->status === 'pending' ? '#ffc107' : 
                                                                ($order->status === 'cancelled' ? '#dc3545' : '#6c757d'))) }}; 
                                                    color: white;">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-light btn-sm">View Details</a>
                                        @if($order->canBeCancelled())
                                            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to cancel this order?')">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">No orders found</h5>
                                <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                                <a href="{{ route('shop') }}" class="btn btn-outline-light">Start Shopping</a>
                            </div>
                        @endif
                    </div>

                    <!-- Profile Section -->
                    <div id="profile" class="dashboard-content" style="display: none;">
                        <h4 class="section-title mb-4">PROFILE INFORMATION</h4>
                        <div class="profile-form p-4">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ $user->first_name ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ $user->last_name ?? '' }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="phone" class="form-control" value="{{ $user->phone ?? '' }}">
                                </div>
                                <button type="submit" class="btn btn-outline-light">UPDATE PROFILE</button>
                            </form>
                        </div>
                    </div>

                    <!-- Addresses Section -->
                    <div id="addresses" class="dashboard-content" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="section-title mb-0">SAVED ADDRESSES</h4>
                            <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addAddressModal">ADD NEW ADDRESS</button>
                        </div>

                        @if($addresses->count() > 0)
                            @foreach($addresses as $address)
                            <div class="address-card p-4 mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6>{{ $address->first_name }} {{ $address->last_name }}</h6>
                                        <p class="mb-0">
                                            {{ $address->address1 }}<br>
                                            @if($address->address2){{ $address->address2 }}<br>@endif
                                            {{ $address->city }}, {{ $address->state }}<br>
                                            {{ $address->country }}<br>
                                            Phone: {{ $address->phone }}
                                        </p>
                                    </div>
                                    <div>
                                        @if($address->is_default)
                                        <span class="badge">Default</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <form action="{{ route('addresses.set-default', $address) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-light btn-sm">Set as Default</button>
                                    </form>
                                    <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Are you sure you want to delete this address?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-map-marker-alt fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">No addresses saved</h5>
                                <p class="text-muted mb-4">Add your first address to make checkout easier.</p>
                                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                    Add Address
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Wishlist Section -->
                    <div id="wishlist" class="dashboard-content" style="display: none;">
                        <h4 class="section-title mb-4">MY WISHLIST</h4>
                        <div class="text-center py-5">
                            <i class="fas fa-heart fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Your wishlist is empty</h5>
                            <p class="text-muted mb-4">Save items you love for later.</p>
                            <a href="{{ route('shop') }}" class="btn btn-outline-light">Explore Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addresses.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street Address</label>
                            <input type="text" name="address1" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address Line 2 (Optional)</label>
                            <input type="text" name="address2" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <select name="state" class="form-select" required>
                                    <option value="">Select State</option>
                                    <option value="Lagos">Lagos</option>
                                    <option value="Abuja">Abuja</option>
                                    <option value="Kano">Kano</option>
                                    <option value="Rivers">Rivers</option>
                                    <option value="Ogun">Ogun</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Postcode</label>
                                <input type="text" name="postcode" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="Nigeria" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_default" id="isDefault">
                            <label class="form-check-label" for="isDefault">
                                Set as default address
                            </label>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-outline-light">Save Address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include("home.footer")

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Dashboard functionality
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.dashboard-content').forEach(section => {
                section.style.display = 'none';
            });
            
            // Remove active class from all sidebar items
            document.querySelectorAll('.sidebar-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionId).style.display = 'block';
            
            // Add active class to clicked sidebar item
            event.currentTarget.classList.add('active');
        }

        // Initialize with Overview visible
        document.addEventListener('DOMContentLoaded', function() {
            showSection('overview');
        });

        // Logout form
        document.getElementById('logout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                this.submit();
            }
        });

        // Show success messages
        @if(session('success'))
            alert('{{ session('success') }}');
        @endif

        @if(session('error'))
            alert('{{ session('error') }}');
        @endif
    </script>
</body>

</html>