@include('admin.header')

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Square button styling */
    .square-btn {
        height: 100%;
        width: 100%;
        min-height: 120px;
        padding: 15px 10px;
        border-radius: 8px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .square-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .square-btn .btn-label {
        font-size: 0.9rem;
        font-weight: 500;
        text-align: center;
    }

    .stats-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .square-btn {
            min-height: 100px;
            padding: 10px 5px;
        }

        .square-btn i {
            font-size: 1.5rem !important;
            margin-bottom: 5px !important;
        }

        .square-btn .btn-label {
            font-size: 0.8rem;
        }
    }
</style>

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title text-dark"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard Overview</h4>
            </div>

            <!-- Stats Cards Row -->
            <div class="row">
                <!-- New Users Card -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-primary card-round stats-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-users stats-icon"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">New Users</p>
                                        <h4 class="card-title">{{ $newUsersCount }}</h4>
                                        <small>Last 7 days</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Categories Card -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-info card-round stats-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-tags stats-icon"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Categories</p>
                                        <h4 class="card-title">{{ $totalCategoriesCount }}</h4>
                                        <small>Active: {{ $totalCategoriesCount }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Products Card -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-success card-round stats-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-cube stats-icon"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Products</p>
                                        <h4 class="card-title">{{ $totalProductsCount }}</h4>
                                        <small>Active products</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Orders Card -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-warning card-round stats-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-shopping-cart stats-icon"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Orders</p>
                                        <h4 class="card-title">{{ $totalOrdersCount }}</h4>
                                        <small>All time orders</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Row -->
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-dark">Quick Actions</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 col-md-3 mb-3">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-block square-btn">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <span class="btn-label">Manage Users</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-md-3 mb-3">
                                    <a href="{{ route('admin.products') }}" class="btn btn-info btn-block square-btn">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-cube fa-2x mb-2"></i>
                                            <span class="btn-label">Manage Products</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-md-3 mb-3">
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-success btn-block square-btn">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-tags fa-2x mb-2"></i>
                                            <span class="btn-label">Manage Categories</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-md-3 mb-3">
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-warning btn-block square-btn">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                            <span class="btn-label">Manage Orders</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <h4 class="card-title text-dark">User Registration Analytics</h4>
                                <div class="card-tools">
                                    <select class="form-control form-control-sm" id="analyticsPeriod">
                                        <option value="week">Last Week</option>
                                        <option value="month" selected>Last Month</option>
                                        <option value="year">Last Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="userAnalyticsChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-dark">Order Status Distribution</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="orderStatusChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <h4 class="card-title text-dark">Recent Users</h4>
                                <div class="card-tools">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Joined</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentUsers as $user)
                                        <tr>
                                            <td>
                                                <div class="avatar-sm float-left mr-3">
                                                    <span class="avatar-title rounded-circle bg-primary text-white">
                                                        {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @if($user->email_verified_at)
                                                <span class="badge badge-success">Verified</span>
                                                @else
                                                <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <h4 class="card-title text-dark">Recent Orders</h4>
                                <div class="card-tools">
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-warning">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary">
                                                    #{{ $order->order_number }}
                                                </a>
                                            </td>
                                            <td>{{ $order->user->first_name ?? 'N/A' }}</td>
                                            <td>${{ number_format($order->total_amount, 2) }}</td>
                                            <td>
                                                @if($order->status == 'delivered')
                                                <span class="badge badge-success">Delivered</span>
                                                @elseif($order->status == 'shipped')
                                                <span class="badge badge-info">Shipped</span>
                                                @elseif($order->status == 'processing')
                                                <span class="badge badge-primary">Processing</span>
                                                @elseif($order->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                                @else
                                                <span class="badge badge-danger">Cancelled</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // User Analytics Chart
    const userCtx = document.getElementById('userAnalyticsChart').getContext('2d');
    const userChart = new Chart(userCtx, {
        type: 'line',
        data: {
            labels: @json($userAnalytics['labels']),
            datasets: [{
                label: 'User Registrations',
                data: @json($userAnalytics['data']),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Order Status Chart
    const orderCtx = document.getElementById('orderStatusChart').getContext('2d');
    const orderChart = new Chart(orderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
            datasets: [{
                data: [12, 19, 3, 5, 2],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(75, 192, 117, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Period selector change
    $('#analyticsPeriod').change(function() {
        const period = $(this).val();
        
        $.ajax({
            url: "{{ route('admin.dashboard.analytics') }}",
            type: "GET",
            data: { period: period },
            success: function(response) {
                userChart.data.labels = response.labels;
                userChart.data.datasets[0].data = response.data;
                userChart.update();
            },
            error: function(xhr) {
                console.log('Error fetching analytics data');
            }
        });
    });
});
</script>

@include('admin.footer')