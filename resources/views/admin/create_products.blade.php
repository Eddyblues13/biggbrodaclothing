@include('admin.header')
<title>Create Product - Admin</title>

<style>
    .upload-progress {
        display: none;
        margin-top: 10px;
    }
    .progress-bar {
        transition: width 0.3s ease;
    }
    .gallery-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    .gallery-preview img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
    }
    .preview-item {
        position: relative;
        display: inline-block;
    }
    .preview-item .remove-btn {
        position: absolute;
        top: -5px;
        right: -5px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        cursor: pointer;
    }
</style>

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            @if(session('message'))
            <div class="alert alert-success mb-2">{{session('message')}}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger mb-2">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mt-2 mb-4">
                <h1 class="title1 text-dark">Create Product</h1>
            </div>

            <div class="container-fluid">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Slug *</label>
                            <input type="text" class="form-control" name="slug" value="{{ old('slug') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select class="form-control" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">SKU *</label>
                            <input type="text" class="form-control" name="sku" value="{{ old('sku') }}" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description *</label>
                            <textarea class="form-control" name="description" rows="4" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Short Description</label>
                            <textarea class="form-control" name="short_description" rows="2">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Brand</label>
                            <input type="text" class="form-control" name="brand" value="{{ old('brand') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Price *</label>
                            <input type="number" class="form-control" name="price" step="0.01" value="{{ old('price') }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Discount Price</label>
                            <input type="number" class="form-control" name="discount_price" step="0.01" value="{{ old('discount_price') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Size (comma separated)</label>
                            <input type="text" class="form-control" name="size" value="{{ old('size') }}" placeholder="S,M,L,XL">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Color (comma separated)</label>
                            <input type="text" class="form-control" name="color" value="{{ old('color') }}" placeholder="Red,Blue,Green">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Stock *</label>
                            <input type="number" class="form-control" name="stock" value="{{ old('stock', 0) }}" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Min Stock *</label>
                            <input type="number" class="form-control" name="min_stock" value="{{ old('min_stock', 5) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Main Image *</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                            <div class="upload-progress" id="mainImageProgress">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted">Uploading...</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gallery Images</label>
                            <input type="file" class="form-control" name="gallery[]" multiple accept="image/*" id="galleryInput">
                            <div class="upload-progress" id="galleryProgress">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted">Uploading...</small>
                            </div>
                            <div class="gallery-preview" id="galleryPreview"></div>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Featured</label>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" name="is_bestseller" id="is_bestseller" {{ old('is_bestseller') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_bestseller">Bestseller</label>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" name="is_new" id="is_new" {{ old('is_new') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_new">New Arrival</label>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status *</label>
                            <select class="form-select" name="status" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title') }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords" value="{{ old('meta_keywords') }}">
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <span id="submitText">Create Product</span>
                                <div id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    const mainImageInput = document.querySelector('input[name="image"]');
    const galleryInput = document.getElementById('galleryInput');
    const mainImageProgress = document.getElementById('mainImageProgress');
    const galleryProgress = document.getElementById('galleryProgress');
    const galleryPreview = document.getElementById('galleryPreview');

    let isUploading = false;

    // Gallery preview
    galleryInput.addEventListener('change', function(e) {
        galleryPreview.innerHTML = '';
        const files = e.target.files;
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-btn" onclick="this.parentElement.remove()">&times;</button>
                `;
                galleryPreview.appendChild(previewItem);
            };
            
            reader.readAsDataURL(file);
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        if (isUploading) {
            e.preventDefault();
            return;
        }

        submitBtn.disabled = true;
        submitText.textContent = 'Creating Product...';
        submitSpinner.classList.remove('d-none');
    });

    // Simulate upload progress (you would integrate with actual Cloudinary upload)
    mainImageInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            simulateUploadProgress(mainImageProgress);
        }
    });

    galleryInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            simulateUploadProgress(galleryProgress);
        }
    });

    function simulateUploadProgress(progressElement) {
        progressElement.style.display = 'block';
        const progressBar = progressElement.querySelector('.progress-bar');
        let width = 0;
        
        const interval = setInterval(() => {
            if (width >= 100) {
                clearInterval(interval);
                setTimeout(() => {
                    progressElement.style.display = 'none';
                }, 1000);
            } else {
                width++;
                progressBar.style.width = width + '%';
            }
        }, 50);
    }
});
</script>

@include('admin.footer')