@include('admin.header')
<style>
    .subscriber-status-badge {
        font-size: 0.75rem;
    }
    .subscriber-actions .btn {
        margin: 2px;
        font-size: 0.75rem;
    }
    .bulk-actions {
        background: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
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
                <h1 class="title1 text-dark">Manage Subscribers</h1>
                <p class="text-muted">Manage newsletter subscribers and email lists</p>
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
                                <option value="activate">Activate Selected</option>
                                <option value="deactivate">Deactivate Selected</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="applyBulkAction">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscriber Filters -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Search Subscribers</label>
                            <input type="text" class="form-control" placeholder="Search by email or name..." id="searchSubscribers" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-control" id="statusFilter">
                                <option value="">All Subscribers</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 text-right" style="margin-top: 30px;">
                            <button class="btn btn-primary" id="applyFilters">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                            <button class="btn btn-secondary" id="resetFilters">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <a href="{{ route('admin.subscribers.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add Subscriber
                            </a>
                            <a href="{{ route('admin.subscribers.export') }}" class="btn btn-info">
                                <i class="fas fa-download"></i> Export
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="subscribersTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="selectAllHeader">
                                    </th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Subscribed</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscribers as $subscriber)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="subscriber-checkbox" value="{{ $subscriber->id }}">
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $subscriber->email }}</div>
                                        <small class="text-muted">ID: {{ $subscriber->id }}</small>
                                    </td>
                                    <td>
                                        @if($subscriber->first_name || $subscriber->last_name)
                                            {{ $subscriber->first_name }} {{ $subscriber->last_name }}
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($subscriber->is_active)
                                        <span class="subscriber-status-badge badge badge-success">Active</span>
                                        @else
                                        <span class="subscriber-status-badge badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $subscriber->created_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $subscriber->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="subscriber-actions">
                                            <a href="{{ route('admin.subscribers.edit', $subscriber->id) }}" 
                                               class="btn btn-sm btn-outline-info" title="Edit Subscriber">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.subscribers.toggle-status', $subscriber->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $subscriber->is_active ? 'warning' : 'success' }}" 
                                                        title="{{ $subscriber->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fas fa-{{ $subscriber->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" 
                                                  class="d-inline" onsubmit="return confirm('Are you sure you want to delete this subscriber?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Subscriber">
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
                            Showing {{ $subscribers->firstItem() }} to {{ $subscribers->lastItem() }} of {{ $subscribers->total() }} subscribers
                        </div>
                        <nav>
                            {{ $subscribers->links() }}
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
    const subscriberCheckboxes = document.querySelectorAll('.subscriber-checkbox');

    function updateSelectAll() {
        const allChecked = Array.from(subscriberCheckboxes).every(cb => cb.checked);
        selectAllHeader.checked = allChecked;
        selectAll.checked = allChecked;
    }

    selectAllHeader.addEventListener('change', function() {
        subscriberCheckboxes.forEach(cb => cb.checked = this.checked);
        selectAll.checked = this.checked;
    });

    selectAll.addEventListener('change', function() {
        subscriberCheckboxes.forEach(cb => cb.checked = this.checked);
        selectAllHeader.checked = this.checked;
    });

    subscriberCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSelectAll);
    });

    // Bulk actions
    document.getElementById('applyBulkAction').addEventListener('click', function() {
        const selectedSubscribers = Array.from(subscriberCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        const action = document.getElementById('bulkAction').value;

        if (selectedSubscribers.length === 0) {
            alert('Please select at least one subscriber.');
            return;
        }

        if (!action) {
            alert('Please select an action.');
            return;
        }

        if (confirm(`Are you sure you want to ${action} ${selectedSubscribers.length} subscriber(s)?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.subscribers.bulk-action") }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            selectedSubscribers.forEach(subscriberId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'subscriber_ids[]';
                input.value = subscriberId;
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
    
    function applySubscriberFilters() {
        const status = document.getElementById('statusFilter').value;
        const search = document.getElementById('searchSubscribers').value;
        
        let url = '{{ route("admin.subscribers.index") }}?';
        const params = [];
        
        if (status) params.push('status=' + status);
        if (search) params.push('search=' + encodeURIComponent(search));
        
        window.location.href = url + params.join('&');
    }
    
    function resetSubscriberFilters() {
        window.location.href = '{{ route("admin.subscribers.index") }}';
    }
    
    applyFilters.addEventListener('click', applySubscriberFilters);
    resetFilters.addEventListener('click', resetSubscriberFilters);
    
    // Enter key search
    document.getElementById('searchSubscribers').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applySubscriberFilters();
        }
    });
});
</script>

@include('admin.footer')