@include('admin.header')

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="title1 text-dark">Edit Category</h1>
                    <p class="text-muted">Update category information</p>
                </div>
                <div>
                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Category
                    </a>
                </div>
            </div>

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Category Information</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group">
                                    <label for="name">Category Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $category->name) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug *</label>
                                    <input type="text" class="form-control" id="slug" name="slug" 
                                           value="{{ old('slug', $category->slug) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="4">{{ old('description', $category->description) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <input type="number" class="form-control" id="position" name="position" 
                                           value="{{ old('position', $category->position) }}" min="0">
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Category
                                        </label>
                                    </div>
                                </div>

                                <hr>
                                <h5>SEO Information</h5>

                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                           value="{{ old('meta_title', $category->meta_title) }}">
                                </div>

                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" 
                                              rows="3">{{ old('meta_description', $category->meta_description) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                           value="{{ old('meta_keywords', $category->meta_keywords) }}">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Category
                                    </button>
                                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Category Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="bg-primary text-white rounded-circle mx-auto mb-3" 
                                     style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-tag fa-2x"></i>
                                </div>
                                <h5>{{ $category->name }}</h5>
                                <p class="text-muted">{{ $category->slug }}</p>
                            </div>

                            <div class="stats-card mb-3">
                                <h4 class="{{ $category->is_active ? 'text-success' : 'text-secondary' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </h4>
                                <p class="mb-0">Status</p>
                            </div>

                            <div class="stats-card mb-3">
                                <h4 class="text-info">{{ $category->products_count }}</h4>
                                <p class="mb-0">Products</p>
                            </div>

                            <div class="stats-card">
                                <h4 class="text-warning">{{ $category->position }}</h4>
                                <p class="mb-0">Position</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Quick Actions</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.categories.toggle-status', $category->id) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-{{ $category->is_active ? 'warning' : 'success' }} btn-block">
                                    <i class="fas fa-{{ $category->is_active ? 'pause' : 'play' }}"></i> 
                                    {{ $category->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info btn-block mb-2">
                                <i class="fas fa-eye"></i> View Details
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fas fa-trash"></i> Delete Category
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')