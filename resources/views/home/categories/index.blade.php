@include("home.header")

<!-- Categories Section -->
<section class="categories-section py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">SHOP BY CATEGORY</h2>
            <a href="{{ route('categories.index') }}" class="explore-all">Home</a>
        </div>
        <div class="categories-container">
            <div class="categories-scroll">
                @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="category-card">
                    <div class="category-image">
                        @php
                        $product = $category->products->first();
                        $galleryImage = $product && $product->galleries->isNotEmpty()
                        ? $product->galleries->first()->image_url
                        : ($product->image_url ?? asset('images/default-category.jpg'));
                        @endphp

                        <img src="{{ $galleryImage }}" alt="{{ $category->name }}" class="img-fluid">

                        <div class="category-overlay">
                            <h3 class="category-name">{{ strtoupper($category->name) }}</h3>
                            <span class="category-count">
                                {{ $category->products_count }}
                                {{ $category->products_count == 1 ? 'Item' : 'Items' }}
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>