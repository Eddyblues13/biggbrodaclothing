@include('admin.header')
<title>Category Form</title>
<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            @if(session('message'))
            <div class="alert alert-success mb-2">{{session('message')}}</div>
            @endif





</html><div class="container py-4">
  <h2 class="mb-4">Create Category</h2>

  <form>

    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" name="name" id="name" required>
    </div>

    <div class="mb-3">
      <label for="slug" class="form-label">Slug</label>
      <input type="text" class="form-control" name="slug" id="slug" required>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" name="description" id="description" rows="3"></textarea>
    </div>

    <div class="mb-3">
      <label for="meta_title" class="form-label">Meta Title</label>
      <input type="text" class="form-control" name="meta_title" id="meta_title">
    </div>

    <div class="mb-3">
      <label for="meta_description" class="form-label">Meta Description</label>
      <textarea class="form-control" name="meta_description" id="meta_description" rows="2"></textarea>
    </div>

    <div class="mb-3">
      <label for="meta_keywords" class="form-label">Meta Keywords</label>
      <input type="text" class="form-control" name="meta_keywords" id="meta_keywords">
    </div>

    <div class="mb-3">
      <label for="position" class="form-label">Position</label>
      <input type="number" class="form-control" name="position" id="position" value="0">
    </div>

    <div class="mb-3">
          <label for="is_active" class="form-label">Status</label>
          <select class="form-select" name="is_active" id="is_active" required>
            <option value="1" selected>Active</option>
            <option value="0">Inactive</option>
          </select>
        </div>


    <button type="submit" class="btn btn-primary">Create Category</button>
  </form>
  <br>
</div>

                        </div>
                    </div>
                </div>
            </div>
         



@include('admin.footer')