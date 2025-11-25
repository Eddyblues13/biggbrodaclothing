@include('admin.header')

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="title1 text-dark">Create Category</h1>
                    <p class="text-muted">Add a new product category</p>
                </div>
                <div>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Categories
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
                            <form action="{{ route('admin.categories.store') }}" method="POST">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="name">Category Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name') }}" placeholder="Enter category name" required>
                                    <small class="form-text text-muted">This will be displayed to customers.</small>
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug *</label>
                                    <input type="text" class="form-control" id="slug" name="slug" 
                                           value="{{ old('slug') }}" placeholder="category-slug" required>
                                    <small class="form-text text-muted">URL-friendly version of the name (lowercase, hyphens instead of spaces).</small>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="4" placeholder="Enter category description">{{ old('description') }}</textarea>
                                    <small class="form-text text-muted">Brief description of the category (optional).</small>
                                </div>

                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <input type="number" class="form-control" id="position" name="position" 
                                           value="{{ old('position', 0) }}" min="0">
                                    <small class="form-text text-muted">Lower numbers appear first in category lists.</small>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Category
                                        </label>
                                        <small class="form-text text-muted">
                                            Inactive categories won't be visible to customers.
                                        </small>
                                    </div>
                                </div>

                                <hr>
                                <h5>SEO Information</h5>
                                <p class="text-muted">Optional SEO fields to improve search engine visibility.</p>

                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                           value="{{ old('meta_title') }}" placeholder="Enter meta title">
                                    <small class="form-text text-muted">Title for search engines (recommended: 50-60 characters).</small>
                                </div>

                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" 
                                              rows="3" placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                                    <small class="form-text text-muted">Description for search engines (recommended: 150-160 characters).</small>
                                </div>

                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                           value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                                    <small class="form-text text-muted">Comma-separated keywords for SEO.</small>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create Category
                                    </button>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tips</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    Use clear, descriptive category names
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    Keep slugs short and URL-friendly
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    Use positions to control display order
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    Add descriptions for better SEO
                                </li>
                                <li>
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    Use meta tags for search optimization
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Quick Stats</h4>
                        </div>
                        <div class="card-body">
                            <div class="stats-card mb-3 bg-primary text-white">
                                <h4>{{ \App\Models\Category::count() }}</h4>
                                <p class="mb-0">Total Categories</p>
                            </div>

                            <div class="stats-card mb-3 bg-success text-white">
                                <h4>{{ \App\Models\Category::where('is_active', true)->count() }}</h4>
                                <p class="mb-0">Active Categories</p>
                            </div>

                            <div class="stats-card bg-info text-white">
                                <h4>{{ \App\Models\Product::count() }}</h4>
                                <p class="mb-0">Total Products</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    nameInput.addEventListener('blur', function() {
        if (!slugInput.value) {
            const slug = this.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        }
    });
});
</script>

@include('admin.footer')