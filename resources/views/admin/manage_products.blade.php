@include('admin.header')
<div class="main-panel">
    <div class="content bg-light">
        <div class="page-inner">
            @if(session('message'))
            <div class="alert alert-success mb-2">{{session('message')}}</div>
            @endif
            <div class="mt-2 mb-4">
                <h1 class="title1 text-dark">Manage Products</h1>
            </div>

            <div>
            </div>
            <div>
            </div>
            <div class="row">
                <div class="col-12">
                   

                    <a href="{{route('create.products')}}"
                        class="float-right btn btn-primary"> <i class='fas fa-plus-circle'></i>Create a New Product</a>
                    
                        <style>
    .pagination li { cursor: pointer; }
  </style>
</head>
<body>
<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Manage Products</h4>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle text-nowrap" id="productTable">
      <thead class="table-light">
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $product)
        <tr>
          <td><img src="{{ asset('storage/' . $product->image) }}" width="50" class="img-thumbnail" alt=""></td>
          <td>{{ $product->name }}</td>
          <td>${{ $product->price }}</td>
          <td>{{ $product->stock }}</td>
          <td>
            <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
              {{ ucfirst($product->status) }}
            </span>
          </td>
          <td>
            <button class="btn btn-sm btn-outline-primary">Edit</button>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
</form>

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Pagination Controls -->
  <nav>
    <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
  </nav>
</div>

<script>
  const rowsPerPage = 5;
  const table = document.getElementById("productTable");
  const tbody = table.querySelector("tbody");
  const rows = tbody.querySelectorAll("tr");
  const pagination = document.getElementById("pagination");

  function showPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    rows.forEach((row, index) => {
      row.style.display = index >= start && index < end ? "" : "none";
    });

    document.querySelectorAll('#pagination li').forEach((li, idx) => {
      li.classList.toggle("active", idx === page);
    });
  }

  function setupPagination() {
    const pageCount = Math.ceil(rows.length / rowsPerPage);
    pagination.innerHTML = '';

    // Prev button
    const prev = document.createElement('li');
    prev.className = 'page-item';
    prev.innerHTML = `<a class="page-link">Prev</a>`;
    prev.onclick = () => {
      const current = pagination.querySelector('li.active');
      const index = [...pagination.children].indexOf(current);
      if (index > 1) showPage(index - 1);
    };
    pagination.appendChild(prev);

    // Page numbers
    for (let i = 1; i <= pageCount; i++) {
      const li = document.createElement('li');
      li.className = 'page-item';
      li.innerHTML = `<a class="page-link">${i}</a>`;
      li.addEventListener('click', () => showPage(i));
      pagination.appendChild(li);
    }

    // Next button
    const next = document.createElement('li');
    next.className = 'page-item';
    next.innerHTML = `<a class="page-link">Next</a>`;
    next.onclick = () => {
      const current = pagination.querySelector('li.active');
      const index = [...pagination.children].indexOf(current);
      if (index < pagination.children.length - 2) showPage(index + 1);
    };
    pagination.appendChild(next);

    showPage(1);
  }

  setupPagination();
</script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         



@include('admin.footer')