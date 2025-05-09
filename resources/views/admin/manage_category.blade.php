@include('admin.header')
<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            @if(session('message'))
            <div class="alert alert-success mb-2">{{session('message')}}</div>
            @endif
            <div class="mt-2 mb-4">
                <h1 class="title1 text-dark">Manage Category</h1>
            </div>

            <div>
            </div>
            <div>
            </div>
            <div class="row">
                <div class="col-12">
                   

                    <a href="{{route('create.category')}}"
                        class="float-right btn btn-primary"> <i class='fas fa-plus-circle'></i>Create a New Category</a>
                    
                        <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-nowrap" id="categoryTable">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Slug</th>
          <th>Meta Title</th>
          <th>Active</th>
          <th>Position</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr>
          <td>{{ $category->name }}</td>
          <td>{{ $category->slug }}</td>
          <td>{{ $category->meta_title }}</td>
          <td>
            @if($category->is_active)
              <span class="badge bg-success">Active</span>
            @else
              <span class="badge bg-secondary">Inactive</span>
            @endif
          </td>
          <td>{{ $category->position }}</td>
          <td>
            <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
            <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- Optional Laravel pagination (can be removed if JS pagination is used) --}}
  {{-- <div class="d-flex justify-content-center mt-3">
    {!! $categories->links() !!}
  </div> --}}
</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         



@include('admin.footer')