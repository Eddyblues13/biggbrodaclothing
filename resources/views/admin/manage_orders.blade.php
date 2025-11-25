@include('admin.header')
<style>
    .order-status {
        font-size: 0.75rem;
        font-weight: 600;
    }
    .payment-status {
        font-size: 0.7rem;
    }
    .customer-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #007bff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.8rem;
    }
    .order-actions .btn {
        margin: 2px;
        font-size: 0.75rem;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .bulk-actions {
        background: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .order-urgent {
        background-color: #fff3cd !important;
        border-left: 4px solid #ffc107;
    }
    .order-completed {
        background-color: #d1ecf1 !important;
        border-left: 4px solid #17a2b8;
    }
</style>

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="mt-2 mb-4">
                <h1 class="title1 text-dark">Manage Orders</h1>
                <p class="text-muted">View and manage customer orders</p>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label" for="selectAll">
                                Select All
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control" id="bulkAction">
                                <option value="">Bulk Actions</option>
                                <option value="approve">Approve Selected</option>
                                <option value="decline">Decline Selected</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="applyBulkAction">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Filters -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Order Status</label>
                            <select class="form-control" id="statusFilter">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-control" id="paymentFilter">
                                <option value="">All Payments</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date From</label>
                            <input type="date" class="form-control" id="dateFrom" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date To</label>
                            <input type="date" class="form-control" id="dateTo" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Search by order number or customer..." id="searchOrders" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary" id="applyFilters">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                            <button class="btn btn-secondary" id="resetFilters">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="ordersTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="selectAllHeader">
                                    </th>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr class="{{ $order->status == 'pending' ? 'order-urgent' : ($order->status == 'delivered' ? 'order-completed' : '') }}">
                                    <td>
                                        <input type="checkbox" class="order-checkbox" value="{{ $order->id }}">
                                    </td>
                                    <td>
                                        <strong>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary">
                                                #{{ $order->order_number }}
                                            </a>
                                        </strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="customer-avatar mr-2">
                                                {{ strtoupper(substr($order->user->first_name ?? 'C', 0, 1)) }}{{ strtoupper(substr($order->user->last_name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold">
                                                    {{ $order->user->first_name ?? 'N/A' }} {{ $order->user->last_name ?? '' }}
                                                </div>
                                                <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $order->order_date->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $order->order_date->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-light">{{ $order->orderItems->count() }} items</span>
                                        <br>
                                        <small class="text-muted">{{ $order->total_quantity }} total</small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-success">${{ number_format($order->total_amount, 2) }}</div>
                                        <small class="text-muted">Incl. tax & shipping</small>
                                    </td>
                                    <td>
                                        <span class="order-status badge 
                                            @if($order->status == 'pending') badge-warning
                                            @elseif($order->status == 'processing') badge-primary
                                            @elseif($order->status == 'shipped') badge-info
                                            @elseif($order->status == 'delivered') badge-success
                                            @else badge-danger @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="payment-status badge 
                                            @if($order->payment_status == 'pending') badge-warning
                                            @elseif($order->payment_status == 'paid') badge-success
                                            @elseif($order->payment_status == 'failed') badge-danger
                                            @else badge-secondary @endif">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                        @if($order->paid_at)
                                            <br><small class="text-muted">{{ $order->paid_at->format('M d, Y') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="order-actions">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                                               class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($order->status == 'pending')
                                            <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Approve Order">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.orders.decline', $order->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Decline Order">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @endif

                                            <!-- Quick Status Update -->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <h6 class="dropdown-header">Update Status</h6>
                                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="processing">
                                                        <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                                                        <button type="submit" class="dropdown-item">Mark as Processing</button>
                                                    </form>
                                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="shipped">
                                                        <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                                                        <button type="submit" class="dropdown-item">Mark as Shipped</button>
                                                    </form>
                                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="delivered">
                                                        <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                                                        <button type="submit" class="dropdown-item">Mark as Delivered</button>
                                                    </form>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <input type="hidden" name="payment_status" value="refunded">
                                                        <button type="submit" class="dropdown-item text-danger">Cancel Order</button>
                                                    </form>
                                                </div>
                                            </div>

                                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" 
                                                  class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Order">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
                        </div>
                        <nav>
                            {{ $orders->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bulk selection
    const selectAllHeader = document.getElementById('selectAllHeader');
    const selectAll = document.getElementById('selectAll');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');

    function updateSelectAll() {
        const allChecked = Array.from(orderCheckboxes).every(cb => cb.checked);
        selectAllHeader.checked = allChecked;
        selectAll.checked = allChecked;
    }

    selectAllHeader.addEventListener('change', function() {
        orderCheckboxes.forEach(cb => cb.checked = this.checked);
        selectAll.checked = this.checked;
    });

    selectAll.addEventListener('change', function() {
        orderCheckboxes.forEach(cb => cb.checked = this.checked);
        selectAllHeader.checked = this.checked;
    });

    orderCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSelectAll);
    });

    // Bulk actions
    document.getElementById('applyBulkAction').addEventListener('click', function() {
        const selectedOrders = Array.from(orderCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        const action = document.getElementById('bulkAction').value;

        if (selectedOrders.length === 0) {
            alert('Please select at least one order.');
            return;
        }

        if (!action) {
            alert('Please select an action.');
            return;
        }

        if (confirm(`Are you sure you want to ${action} ${selectedOrders.length} order(s)?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.orders.bulk-action") }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            selectedOrders.forEach(orderId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'order_ids[]';
                input.value = orderId;
                form.appendChild(input);
            });

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;
            form.appendChild(actionInput);

            document.body.appendChild(form);
            form.submit();
        }
    });

    // Filter functionality
    const applyFilters = document.getElementById('applyFilters');
    const resetFilters = document.getElementById('resetFilters');
    
    function applyOrderFilters() {
        const status = document.getElementById('statusFilter').value;
        const paymentStatus = document.getElementById('paymentFilter').value;
        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo = document.getElementById('dateTo').value;
        const search = document.getElementById('searchOrders').value;
        
        let url = '{{ route("admin.orders.index") }}?';
        const params = [];
        
        if (status) params.push('status=' + status);
        if (paymentStatus) params.push('payment_status=' + paymentStatus);
        if (dateFrom) params.push('date_from=' + dateFrom);
        if (dateTo) params.push('date_to=' + dateTo);
        if (search) params.push('search=' + encodeURIComponent(search));
        
        window.location.href = url + params.join('&');
    }
    
    function resetOrderFilters() {
        window.location.href = '{{ route("admin.orders.index") }}';
    }
    
    applyFilters.addEventListener('click', applyOrderFilters);
    resetFilters.addEventListener('click', resetOrderFilters);
    
    // Enter key search
    document.getElementById('searchOrders').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyOrderFilters();
        }
    });
});
</script>

@include('admin.footer')