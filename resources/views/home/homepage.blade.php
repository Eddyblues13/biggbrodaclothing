@include("home.header")

<!-- Hero Carousel Section -->
<section class="hero-carousel">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('img/hero-img.jpg')">
                <div class="carousel-caption">
                    <button class="btn btn-outline-light">EXPLORE OUR NEW COLLECTION</button>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('img/hero-image.jpg')">
                <div class="carousel-caption">
                    <button class="btn btn-outline-light">SHOP NOW</button>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('img/img-3.jpg')">
                <div class="carousel-caption">
                    <button class="btn btn-outline-light">DISCOVER MORE</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- New In Section -->
<section class="new-in py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">NEW IN</h2>
            <a href="" class="explore-all">EXPLORE ALL</a>
        </div>
        <div class="row">
            @php
            $newProducts = App\Models\Product::active()
            ->newArrivals()
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
            @endphp

            @foreach($newProducts as $product)
            <div class="col-md-3 col-6 mb-4">
                <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                    <div class="product-card">
                        <div class="product-image position-relative">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="img-fluid">

                            @if($product->is_on_sale)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                -{{ $product->discount_percentage }}%
                            </span>
                            @endif
                        </div>
                        <div class="product-info mt-2">
                            <h3 class="product-title fs-6">{{ $product->name }}</h3>
                            <div class="d-flex align-items-center gap-2">
                                <p class="product-price mb-0 @if($product->is_on_sale) text-danger @endif">
                                    ₦ {{ number_format($product->current_price, 2) }}
                                </p>
                                @if($product->is_on_sale)
                                <p class="product-price text-muted mb-0 text-decoration-line-through">
                                    ₦ {{ number_format($product->price, 2) }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>



<!-- Categories Section -->
<section class="categories-section py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">SHOP BY CATEGORY</h2>
            <a href="{{ route('categories.index') }}" class="explore-all">VIEW ALL</a>
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


<!-- Featured Products -->
<section class="featured-products py-5">
    <div class="container">
        <h2 class="section-title mb-4">FEATURED PRODUCTS</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-md-3 col-6 mb-4">
                <a href="{{ route('product.show', $product) }}" class="product-card text-decoration-none text-dark">
                    <div class="product-image position-relative">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid">
                        @if($product->is_on_sale)
                        <span class="badge bg-danger position-absolute top-0 start-0 mt-2 ms-2">
                            SALE
                        </span>
                        @endif
                    </div>
                    <div class="product-info mt-2">
                        <h3 class="product-title h6 mb-1">{{ $product->name }}</h3>
                        <div class="d-flex align-items-center">
                            @if($product->is_on_sale)
                            <p class="product-price text-danger mb-0 me-2">
                                ₦ {{ number_format($product->current_price, 2) }}
                            </p>
                            <p class="product-price text-muted mb-0 text-decoration-line-through">
                                ₦ {{ number_format($product->price, 2) }}
                            </p>
                            @else
                            <p class="product-price mb-0">
                                ₦ {{ number_format($product->price, 2) }}
                            </p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Collection Banner -->
<section class="collection-banner">
    <div class="container-fluid p-0">
        <div class="banner-content">
            <h2>THE NEW COLLECTION IS THE SYNTHESIS OF THE HARMONIOUS ELEMENTS OF PLAYFUL ELEGANCE</h2>
            <button class="btn btn-outline-light">EXPLORE OUR NEW COLLECTION</button>
        </div>
    </div>
</section>

<!-- Subscription Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content subscription-modal-content">
            <div class="modal-header position-absolute top-0 end-0 border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 text-center">
                <h2 class="modal-title fw-bold mb-3">Hey! let's keep in touch.</h2>
                <p class="modal-subtitle mb-4">Signup to get exclusive offers and great content before you</p>

                <form id="subscriptionForm" class="subscription-form">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control py-3" placeholder="Enter email here" aria-label="Email"
                            name="email" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-3">
                        Be the first to get offer
                    </button>
                </form>

                <p class="brand-notice mt-4 mb-0">
                    * Not affiliated with or endorsed by any brands unless explicitly stated
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Success Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Success!</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Thank you for subscribing! You'll be the first to receive our exclusive offers.
        </div>
    </div>
</div>

<style>
    /* Subscription Modal Styles */
    .subscription-modal-content {
        border-radius: 0;
        border: none;
        background-color: #fff;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        margin: 0 auto;
    }

    .modal-title {
        font-size: 2.5rem;
        line-height: 1.2;
        letter-spacing: -0.5px;
    }

    .modal-subtitle {
        font-size: 1.2rem;
        color: #666;
        max-width: 400px;
        margin: 0 auto;
    }

    .subscription-form .form-control {
        border: 2px solid #000;
        border-radius: 0;
        padding: 12px 20px;
        font-size: 1.1rem;
        text-align: center;
    }

    .subscription-form .form-control:focus {
        box-shadow: none;
        border-color: #000;
    }

    .subscription-form .btn {
        border-radius: 0;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 1.1rem;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .subscription-form .btn:hover {
        background-color: #333;
        transform: translateY(-2px);
    }

    .brand-notice {
        font-size: 0.85rem;
        color: #888;
        font-style: italic;
        max-width: 400px;
        margin: 0 auto;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modal-title {
            font-size: 2rem;
        }

        .modal-subtitle {
            font-size: 1rem;
        }

        .modal-body {
            padding: 2rem !important;
        }

        .subscription-form .form-control,
        .subscription-form .btn {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .modal-title {
            font-size: 1.75rem;
        }

        .modal-body {
            padding: 1.5rem !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap components
        const subscriptionModal = new bootstrap.Modal(document.getElementById('subscriptionModal'));
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        
        // Show modal after 3 seconds
        setTimeout(() => {
            subscriptionModal.show();
        }, 3000);
        
        // Handle form submission
        const subscriptionForm = document.getElementById('subscriptionForm');
        
        subscriptionForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const email = formData.get('email');
            
            try {
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Subscribing...';
                submitBtn.disabled = true;
                
                // Simulate API call (replace with actual fetch to your endpoint)
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Show success toast
                successToast.show();
                
                // Reset form
                this.reset();
                
                // Close modal after 2 seconds
                setTimeout(() => {
                    subscriptionModal.hide();
                }, 2000);
                
            } catch (error) {
                console.error('Subscription error:', error);
                alert('An error occurred. Please try again.');
            } finally {
                // Reset button
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            }
        });
    });
</script>

@include("home.footer")