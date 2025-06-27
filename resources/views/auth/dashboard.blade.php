<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head content remains the same -->
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand mx-auto" href="{{ url('/') }}">
                <h1 class="logo">Biggbroda</h1>
            </a>
            <div class="navbar-nav">
                <a class="nav-link" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">LOGOUT</a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <section class="dashboard-section py-5" style="margin-top: 100px;">
        <div class="container">
            <!-- Welcome Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="welcome-card p-4">
                        <h1 class="section-title mb-2">WELCOME BACK, {{ strtoupper(Auth::user()->name) }}</h1>
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
                                    <i class="fas fa-star mb-2"></i>
                                    <h3>VIP</h3>
                                    <p class="mb-0">Member Status</p>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Orders -->
                        <div class="recent-orders mb-4">
                            <h4 class="section-title mb-3">RECENT ORDERS</h4>
                            @foreach($recentOrders as $order)
                            <div class="order-card p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6>#{{ $order->order_number }}</h6>
                                        <p class="mb-0">{{ $order->order_date->format('F d, Y') }}</p>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0">₦ {{ number_format($order->total, 2) }}</p>
                                        <span class="badge"
                                            style="background: {{ $order->status === 'delivered' ? '#28a745' : '#ffc107' }}; color: {{ $order->status === 'delivered' ? 'white' : '#101320' }};">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Orders Section -->
                    <div id="orders" class="dashboard-content" style="display: none;">
                        <h4 class="section-title mb-4">MY ORDERS</h4>
                        @foreach($user->orders as $order)
                        <div class="order-item p-4 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <h6>#{{ $order->order_number }}</h6>
                                    <p class="mb-0">{{ $order->order_date->format('F d, Y') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">2 Items</p>
                                    <p class="mb-0">₦ {{ number_format($order->total, 2) }}</p>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge"
                                        style="background: {{ $order->status === 'delivered' ? '#28a745' : '#ffc107' }}; color: {{ $order->status === 'delivered' ? 'white' : '#101320' }};">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <button class="btn btn-outline-secondary btn-sm">View Details</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Profile Section -->
                    <div id="profile" class="dashboard-content" style="display: none;">
                        <h4 class="section-title mb-4">PROFILE INFORMATION</h4>
                        <div class="profile-form p-4">
                            <form action="" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ explode(' ', $user->name)[0] }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ explode(' ', $user->name)[1] ?? '' }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="phone" class="form-control" value="{{ $user->phone }}">
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

                        @foreach($addresses as $address)
                        <div class="address-card p-4 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6>{{ $address->title }}</h6>
                                    <p class="mb-0">
                                        {{ $address->address }}<br>
                                        {{ $address->city }}, {{ $address->state }}<br>
                                        {{ $address->phone }}
                                    </p>
                                </div>
                                <div>
                                    @if($address->is_default)
                                    <span class="badge">Default</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-4">
        <!-- Footer content remains the same -->
    </footer>

    <!-- Bootstrap JS -->
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
            event.target.classList.add('active');
        }

        // Initialize with Overview visible
        document.addEventListener('DOMContentLoaded', function() {
            showSection('overview');
        });
    </script>
</body>

</html>