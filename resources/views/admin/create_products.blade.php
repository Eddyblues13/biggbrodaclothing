@include('admin.header')
<title>Product Form</title>

<!-- Bootstrap 5 CSS -->

<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            @if(session('message'))
            <div class="alert alert-success mb-2">{{session('message')}}</div>
            @endif
            <div class="mt-2 mb-4">
                <h1 class="title1 text-dark">Create Products</h1>
            </div>

            <div>
            </div>
            <div>
            </div>



<div class="container py-5">
  <h2 class="mb-4">Product Form</h2>
  <form>
    <div class="row g-3">

      <div class="col-md-6">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name">
      </div>

      <div class="col-md-6">
        <label class="form-label">Slug</label>
        <input type="text" class="form-control" name="slug">
      </div>

      <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3"></textarea>
      </div>

      <div class="col-md-12">
        <label class="form-label">Short Description</label>
        <textarea class="form-control" name="short_description" rows="2"></textarea>
      </div>

      <div class="col-md-6">
        <label class="form-label">SKU</label>
        <input type="text" class="form-control" name="sku">
      </div>

      <div class="col-md-6">
        <label class="form-label">Brand</label>
        <input type="text" class="form-control" name="brand">
      </div>

      <div class="col-md-4">
        <label class="form-label">Price</label>
        <input type="number" class="form-control" name="price" step="0.01">
      </div>

      <div class="col-md-4">
        <label class="form-label">Discount Price</label>
        <input type="number" class="form-control" name="discount_price" step="0.01">
      </div>

      <div class="col-md-4">
        <label class="form-label">Size</label>
        <input type="text" class="form-control" name="size">
      </div>

      <div class="col-md-4">
        <label class="form-label">Color</label>
        <input type="text" class="form-control" name="color">
      </div>

      <div class="col-md-4">
        <label class="form-label">Stock</label>
        <input type="number" class="form-control" name="stock">
      </div>

      <div class="col-md-4">
        <label class="form-label">Min Stock</label>
        <input type="number" class="form-control" name="min_stock">
      </div>

      <div class="col-md-6">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image">
      </div>

      <div class="col-md-6">
        <label class="form-label">Image Public ID</label>
        <input type="text" class="form-control" name="image_public_id">
      </div>

      <div class="col-md-12">
        <label class="form-label">Gallery (multiple)</label>
        <input type="file" class="form-control" name="gallery[]" multiple>
      </div>

      <div class="col-md-4 form-check">
        <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured">
        <label class="form-check-label" for="is_featured">Featured</label>
      </div>

      <div class="col-md-4 form-check">
        <input class="form-check-input" type="checkbox" name="is_bestseller" id="is_bestseller">
        <label class="form-check-label" for="is_bestseller">Bestseller</label>
      </div>

      <div class="col-md-4 form-check">
        <input class="form-check-input" type="checkbox" name="is_new" id="is_new">
        <label class="form-check-label" for="is_new">New</label>
      </div>

      <div class="col-md-6">
        <label class="form-label">Status</label>
        <select class="form-select" name="status">
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Meta Title</label>
        <input type="text" class="form-control" name="meta_title">
      </div>

      <div class="col-md-12">
        <label class="form-label">Meta Description</label>
        <textarea class="form-control" name="meta_description" rows="2"></textarea>
      </div>

      <div class="col-md-12">
        <label class="form-label">Meta Keywords</label>
        <input type="text" class="form-control" name="meta_keywords">
      </div>

      <div class="col-12 mt-4">
        <button type="submit" class="btn btn-primary w-100">Submit</button>
      </div>
    </div>
  </form>
</div>

<!-- Bootstrap 5 JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

                        </div>
                    </div>
                </div>
            </div>
         



@include('admin.footer')