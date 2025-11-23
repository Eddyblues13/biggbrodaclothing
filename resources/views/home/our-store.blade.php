<!-- our-store.blade.php -->
@include("home.header")

<!-- Store Hero Section -->
<section class="store-hero py-5" style="margin-top: 100px; background: linear-gradient(rgba(16,19,32,0.8), rgba(16,19,32,0.8)), url('img/store-hero.jpg'); background-size: cover; background-position: center; color: white;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="section-title mb-4 text-white">OUR STORE</h1>
                <p class="lead mb-4">Experience the BIGGBRODA difference in person</p>
                <a href="#locations" class="btn btn-outline-light me-3">VISIT US</a>
                <a href="{{ route('shop') }}" class="btn btn-light">SHOP ONLINE</a>
            </div>
        </div>
    </div>
</section>

<!-- Store Experience Section -->
<section class="store-experience py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">THE BIGGBRODA EXPERIENCE</h2>
                <p class="text-muted">More than just a store - it's a destination for streetwear enthusiasts</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="experience-card text-center p-4 h-100">
                    <div class="experience-icon mb-3">
                        <i class="fas fa-tshirt fa-3x" style="color: #cca264;"></i>
                    </div>
                    <h4 class="mb-3">Curated Collections</h4>
                    <p class="text-muted">
                        Explore our handpicked selection of streetwear essentials, limited editions, and exclusive drops you won't find anywhere else.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="experience-card text-center p-4 h-100">
                    <div class="experience-icon mb-3">
                        <i class="fas fa-hands-helping fa-3x" style="color: #cca264;"></i>
                    </div>
                    <h4 class="mb-3">Expert Styling</h4>
                    <p class="text-muted">
                        Our knowledgeable staff are here to help you find your perfect fit and create looks that express your unique style.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="experience-card text-center p-4 h-100">
                    <div class="experience-icon mb-3">
                        <i class="fas fa-music fa-3x" style="color: #cca264;"></i>
                    </div>
                    <h4 class="mb-3">Cultural Hub</h4>
                    <p class="text-muted">
                        More than a store - we host events, showcases, and gatherings that celebrate urban culture and creativity.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Store Locations Section -->
<section class="store-locations py-5 bg-light" id="locations">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">FIND US</h2>
                <p class="text-muted">Visit one of our flagship locations</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="location-card bg-white rounded shadow-sm overflow-hidden">
                    <div class="location-image">
                        <img src="{{ asset('img/lagos-store.jpg') }}" alt="Lagos Store" class="img-fluid w-100" style="height: 250px; object-fit: cover;">
                    </div>
                    <div class="location-content p-4">
                        <h4 class="mb-3">Lagos Flagship Store</h4>
                        <div class="location-info mb-3">
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt me-2" style="color: #cca264;"></i>
                                123 Fashion Street, Victoria Island, Lagos
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-phone me-2" style="color: #cca264;"></i>
                                +234 801 234 5678
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-clock me-2" style="color: #cca264;"></i>
                                Mon-Sat: 9AM - 8PM, Sun: 11AM - 6PM
                            </p>
                        </div>
                        <a href="https://maps.google.com" target="_blank" class="btn btn-outline-dark">GET DIRECTIONS</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="location-card bg-white rounded shadow-sm overflow-hidden">
                    <div class="location-image">
                        <img src="{{ asset('img/abuja-store.jpg') }}" alt="Abuja Store" class="img-fluid w-100" style="height: 250px; object-fit: cover;">
                    </div>
                    <div class="location-content p-4">
                        <h4 class="mb-3">Abuja Concept Store</h4>
                        <div class="location-info mb-3">
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt me-2" style="color: #cca264;"></i>
                                456 Central District, Wuse 2, Abuja
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-phone me-2" style="color: #cca264;"></i>
                                +234 802 345 6789
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-clock me-2" style="color: #cca264;"></i>
                                Mon-Sat: 10AM - 7PM, Sun: 12PM - 5PM
                            </p>
                        </div>
                        <a href="https://maps.google.com" target="_blank" class="btn btn-outline-dark">GET DIRECTIONS</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <p class="text-muted">Coming soon to Port Harcourt and Kano</p>
            </div>
        </div>
    </div>
</section>

<!-- In-Store Services Section -->
<section class="store-services py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">IN-STORE SERVICES</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-6 mb-4">
                <div class="service-item text-center">
                    <div class="service-icon mb-3">
                        <i class="fas fa-ruler-combined fa-2x" style="color: #cca264;"></i>
                    </div>
                    <h6 class="mb-2">Professional Fitting</h6>
                    <p class="text-muted small">Get expert advice on sizing and fit</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="service-item text-center">
                    <div class="service-icon mb-3">
                        <i class="fas fa-gift fa-2x" style="color: #cca264;"></i>
                    </div>
                    <h6 class="mb-2">Gift Wrapping</h6>
                    <p class="text-muted small">Complimentary gift wrapping service</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="service-item text-center">
                    <div class="service-icon mb-3">
                        <i class="fas fa-undo-alt fa-2x" style="color: #cca264;"></i>
                    </div>
                    <h6 class="mb-2">Easy Returns</h6>
                    <p class="text-muted small">Hassle-free in-store returns</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="service-item text-center">
                    <div class="service-icon mb-3">
                        <i class="fas fa-truck fa-2x" style="color: #cca264;"></i>
                    </div>
                    <h6 class="mb-2">Home Delivery</h6>
                    <p class="text-muted small">Free delivery within city limits</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section class="store-events py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">UPCOMING EVENTS</h2>
                <p class="text-muted">Join us for exclusive in-store experiences</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="event-card bg-white rounded shadow-sm overflow-hidden">
                    <div class="event-date p-3 text-center text-white" style="background: #cca264;">
                        <h4 class="mb-0">15</h4>
                        <p class="mb-0">DEC</p>
                    </div>
                    <div class="event-content p-3">
                        <h5 class="mb-2">Limited Edition Drop</h5>
                        <p class="text-muted small mb-2">Exclusive release of our Winter Collection</p>
                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt me-1" style="color: #cca264;"></i>
                            <small>Lagos Store</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="event-card bg-white rounded shadow-sm overflow-hidden">
                    <div class="event-date p-3 text-center text-white" style="background: #cca264;">
                        <h4 class="mb-0">22</h4>
                        <p class="mb-0">DEC</p>
                    </div>
                    <div class="event-content p-3">
                        <h5 class="mb-2">Live DJ & Shopping Night</h5>
                        <p class="text-muted small mb-2">Music, drinks, and special discounts</p>
                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt me-1" style="color: #cca264;"></i>
                            <small>Abuja Store</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="event-card bg-white rounded shadow-sm overflow-hidden">
                    <div class="event-date p-3 text-center text-white" style="background: #cca264;">
                        <h4 class="mb-0">07</h4>
                        <p class="mb-0">JAN</p>
                    </div>
                    <div class="event-content p-3">
                        <h5 class="mb-2">Style Workshop</h5>
                        <p class="text-muted small mb-2">Learn to build your streetwear wardrobe</p>
                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt me-1" style="color: #cca264;"></i>
                            <small>Lagos Store</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="store-contact py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="section-title mb-4">HAVE QUESTIONS?</h2>
                <p class="text-muted mb-4">Our team is here to help with any inquiries about our stores, products, or events.</p>
                <div class="contact-options">
                    <a href="tel:+2348012345678" class="btn btn-outline-dark me-3 mb-2">
                        <i class="fas fa-phone me-2"></i>CALL US
                    </a>
                    <a href="mailto:info@biggbroda.com" class="btn btn-outline-dark me-3 mb-2">
                        <i class="fas fa-envelope me-2"></i>EMAIL US
                    </a>
                    <a href="https://wa.me/2348012345678" target="_blank" class="btn btn-outline-dark mb-2">
                        <i class="fab fa-whatsapp me-2"></i>WHATSAPP
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .section-title {
        font-weight: 700;
        color: #101320;
        position: relative;
        display: inline-block;
    }
    
    .section-title:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #cca264;
    }
    
    .text-center .section-title:after {
        left: 50%;
        transform: translateX(-50%);
    }
    
    .experience-card, .location-card, .event-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .experience-card:hover, .location-card:hover, .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .service-item {
        padding: 20px 10px;
        border-radius: 8px;
        transition: background 0.3s ease;
    }
    
    .service-item:hover {
        background: rgba(204, 162, 100, 0.05);
    }
    
    .event-date {
        min-width: 80px;
    }
    
    @media (max-width: 768px) {
        .store-hero {
            margin-top: 80px !important;
        }
        
        .store-hero .btn {
            display: block;
            width: 200px;
            margin: 10px auto;
        }
        
        .contact-options .btn {
            display: block;
            width: 200px;
            margin: 10px auto;
        }
    }
</style>

@include("home.footer")