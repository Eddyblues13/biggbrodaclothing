@include('admin.header')
<style>
    .category-status-badge { font-size: 0.75rem; }
    .category-actions .btn { margin: 2px; font-size: 0.75rem; }
    .product-count-badge { font-size: 0.7rem; }
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
                <h1 class="title1 text-dark">Manage Categories</h1>
                <p class="text-muted">Organize and manage product categories</p>
            </div>

            <!-- Simple Add Button -->
            <div class="mb-3">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add New Category
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th>Position</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($categories->count() > 0)
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $category->name }}</div>
                                            @if($category->description)
                                            <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <code>{{ $category->slug }}</code>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $category->products_count ?? 0 }} products</span>
                                        </td>
                                        <td>
                                            @if($category->is_active)
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-light">{{ $category->position }}</span>
                                        </td>
                                        <td>
                                            {{ $category->created_at->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <div class="category-actions">
                                                <a href="{{ route('admin.categories.show', $category->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                                   class="btn btn-sm btn-outline-info" title="Edit Category">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.categories.toggle-status', $category->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-{{ $category->is_active ? 'warning' : 'success' }}" 
                                                            title="{{ $category->is_active ? 'Deactivate' : 'Activate' }}">
                                                        <i class="fas fa-{{ $category->is_active ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" 
                                                      class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Category">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No categories found.</p>
                                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Create First Category
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Safe Pagination - Only show if it's a paginator instance -->
                    @if(method_exists($categories, 'links'))
                    <div class="d-flex justify-content-center mt-3">
                        {{ $categories->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')