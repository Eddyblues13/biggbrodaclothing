@include('admin.header')
<style>
    .pagination li { cursor: pointer; }
    .product-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }
    .status-badge {
        font-size: 0.75rem;
    }
    .action-buttons .btn {
        margin: 2px;
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
                <h1 class="title1 text-dark">Manage Products</h1>
                <p class="text-muted">Manage your product inventory and listings</p>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search products..." id="searchInput">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="searchButton">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class='fas fa-plus-circle'></i> Create New Product
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="productTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>
                                        @if($product->image_public_id)
                                            <img src="{{ $product->thumbnail_url }}" class="product-image img-thumbnail" alt="{{ $product->name }}">
                                        @else
                                            <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-cube text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $product->name }}</div>
                                        <small class="text-muted">SKU: {{ $product->sku }}</small>
                                    </td>
                                    <td>
                                        @if($product->category)
                                            <span class="badge badge-info">{{ $product->category->name }}</span>
                                        @else
                                            <span class="badge badge-secondary">Uncategorized</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">${{ number_format($product->price, 2) }}</div>
                                        @if($product->is_on_sale)
                                            <small class="text-success">Sale: ${{ number_format($product->current_price, 2) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="font-weight-bold {{ $product->stock <= $product->min_stock ? 'text-danger' : 'text-success' }}">
                                            {{ $product->stock }}
                                        </span>
                                        @if($product->stock <= $product->min_stock)
                                            <br><small class="text-danger">Low Stock</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge status-badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->is_featured)
                                            <i class="fas fa-star text-warning" title="Featured"></i>
                                        @endif
                                        @if($product->is_bestseller)
                                            <i class="fas fa-fire text-danger" title="Bestseller"></i>
                                        @endif
                                        @if($product->is_new)
                                            <i class="fas fa-certificate text-info" title="New Arrival"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.products.toggle-status', $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $product->status === 'active' ? 'warning' : 'success' }}" 
                                                        title="{{ $product->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fas fa-{{ $product->status === 'active' ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" 
                                                  class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products
                        </div>
                        <nav>
                            {{ $products->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        if (searchTerm) {
            window.location.href = '{{ route("admin.products") }}?search=' + encodeURIComponent(searchTerm);
        }
    }
    
    searchButton.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    // Auto-refresh stock warnings
    function checkLowStock() {
        document.querySelectorAll('tr').forEach(row => {
            const stockCell = row.querySelector('td:nth-child(5)');
            if (stockCell && stockCell.querySelector('.text-danger')) {
                row.classList.add('table-warning');
            }
        });
    }
    
    checkLowStock();
});
</script>

@include('admin.footer')