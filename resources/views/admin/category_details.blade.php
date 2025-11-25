@include('admin.header')
<style>
    .category-details-card {
        border-left: 4px solid #007bff;
    }
    .category-products-card {
        border-left: 4px solid #28a745;
    }
    .category-stats-card {
        border-left: 4px solid #ffc107;
    }
    .category-icon {
        font-size: 3rem;
        color: #007bff;
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
                    <h1 class="title1 text-dark">Category Details</h1>
                    <p class="text-muted">{{ $category->name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Categories
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

            <div class="row">
                <!-- Category Information -->
                <div class="col-md-4">
                    <div class="card category-details-card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Category Information</h4>
                        </div>
                        <div class="card-body text-center">
                            <div class="category-icon mb-3">
                                <i class="fas fa-tag"></i>
                            </div>
                            <h4>{{ $category->name }}</h4>
                            <p class="text-muted">{{ $category->slug }}</p>
                            
                            <div class="category-info text-left">
                                <p><strong>Status:</strong> 
                                    @if($category->is_active)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </p>
                                <p><strong>Position:</strong> {{ $category->position }}</p>
                                <p><strong>Products:</strong> {{ $category->products_count }}</p>
                                <p><strong>Created:</strong> {{ $category->created_at->format('F d, Y') }}</p>
                                <p><strong>Updated:</strong> {{ $category->updated_at->format('F d, Y') }}</p>
                            </div>

                            @if($category->description)
                            <div class="mt-3 text-left">
                                <strong>Description:</strong>
                                <p class="text-muted">{{ $category->description }}</p>
                            </div>
                            @endif

                            <div class="category-actions mt-3">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit Category
                                </a>
                                <form action="{{ route('admin.categories.toggle-status', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $category->is_active ? 'warning' : 'success' }} btn-sm">
                                        <i class="fas fa-{{ $category->is_active ? 'pause' : 'play' }}"></i> 
                                        {{ $category->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Information -->
                    <div class="card category-stats-card">
                        <div class="card-header">
                            <h4 class="card-title">SEO Information</h4>
                        </div>
                        <div class="card-body">
                            @if($category->meta_title)
                            <p><strong>Meta Title:</strong><br>{{ $category->meta_title }}</p>
                            @endif
                            
                            @if($category->meta_description)
                            <p><strong>Meta Description:</strong><br>{{ $category->meta_description }}</p>
                            @endif
                            
                            @if($category->meta_keywords)
                            <p><strong>Meta Keywords:</strong><br>{{ $category->meta_keywords }}</p>
                            @endif
                            
                            @if(!$category->meta_title && !$category->meta_description && !$category->meta_keywords)
                            <p class="text-muted text-center">No SEO information added.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Products -->
                <div class="col-md-8">
                    <div class="card category-products-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Products in this Category</h4>
                            <span class="badge badge-primary">{{ $category->products_count }} total products</span>
                        </div>
                        <div class="card-body">
                            @if($category->products->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($category->products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($product->image_public_id)
                                                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" 
                                                         class="img-thumbnail" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @endif
                                                    <div class="ml-3">
                                                        <strong>{{ $product->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">SKU: {{ $product->sku }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>
                                                <span class="badge badge-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No products found in this category.</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Product
                                </a>
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