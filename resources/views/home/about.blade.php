
<!-- about.blade.php -->
@include("home.header")

<!-- About Hero Section -->
<section class="about-hero py-5" style="margin-top: 100px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="section-title mb-4">ABOUT BIGGBRODA</h1>
                <p class="lead mb-4" style="color: #666; line-height: 1.8;">
                    We're urban alchemists transforming fabric into attitude. At BIGGBRODA, we stitch rebellion into every seam and weave confidence into every thread.
                </p>
                <p style="color: #666; line-height: 1.8;">
                    Born from concrete dreams and midnight inspiration, our pieces are armor for the style warriors designed not just to dress bodies, but to amplify personalities. Where street culture breathes and individuality thrives, we craft the uniform for the unapologetically bold.
                </p>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('img/about-hero.jpg') }}" alt="About Biggbroda" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="our-story py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">OUR STORY</h2>
                <p class="text-muted">From humble beginnings to streetwear revolution</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="story-card text-center p-4 bg-white rounded shadow-sm h-100">
                    <div class="story-icon mb-3">
                        <i class="fas fa-seedling fa-2x" style="color: #cca264;"></i>
                    </div>
                    <h4 class="mb-3">The Beginning</h4>
                    <p class="text-muted">
                        Founded in 2018, BIGGBRODA started as a small passion project in a garage, driven by the vision to create clothing that speaks to the urban soul.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="story-card text-center p-4 bg-white rounded shadow-sm h-100">
                    <div class="story-icon mb-3">
                        <i class="fas fa-rocket fa-2x" style="color: #cca264;"></i>
                    </div>
                    <h4 class="mb-3">Rapid Growth</h4>
                    <p class="text-muted">
                        Through authentic designs and quality craftsmanship, we quickly gained recognition in the streetwear community, expanding our reach across Nigeria.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="story-card text-center p-4 bg-white rounded shadow-sm h-100">
                    <div class="story-icon mb-3">
                        <i class="fas fa-crown fa-2x" style="color: #cca264;"></i>
                    </div>
                    <h4 class="mb-3">Today & Beyond</h4>
                    <p class="text-muted">
                        Now a leading name in African streetwear, we continue to push boundaries while staying true to our roots and the culture that inspired us.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">OUR VALUES</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="value-item d-flex">
                    <div class="value-icon me-4">
                        <i class="fas fa-gem fa-2x" style="color: #cca264;"></i>
                    </div>
                    <div class="value-content">
                        <h4 class="mb-3">Quality Craftsmanship</h4>
                        <p class="text-muted mb-0">
                            Every stitch, every fabric, every detail is carefully considered to ensure our products meet the highest standards of quality and durability.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="value-item d-flex">
                    <div class="value-icon me-4">
                        <i class="fas fa-palette fa-2x" style="color: #cca264;"></i>
                    </div>
                    <div class="value-content">
                        <h4 class="mb-3">Creative Expression</h4>
                        <p class="text-muted mb-0">
                            We believe clothing is a form of self-expression. Our designs celebrate individuality and empower people to showcase their unique style.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="value-item d-flex">
                    <div class="value-icon me-4">
                        <i class="fas fa-users fa-2x" style="color: #cca264;"></i>
                    </div>
                    <div class="value-content">
                        <h4 class="mb-3">Community Focus</h4>
                        <p class="text-muted mb-0">
                            We're more than a brand - we're a community. We actively engage with our customers and support local artists and creators.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="value-item d-flex">
                    <div class="value-icon me-4">
                        <i class="fas fa-leaf fa-2x" style="color: #cca264;"></i>
                    </div>
                    <div class="value-content">
                        <h4 class="mb-3">Sustainable Practices</h4>
                        <p class="text-muted mb-0">
                            We're committed to reducing our environmental impact through responsible sourcing and sustainable manufacturing processes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">MEET THE FOUNDERS</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="team-card text-center bg-white rounded shadow-sm p-4">
                    <div class="team-image mb-3">
                        <img src="{{ asset('img/team-1.jpg') }}" alt="Founder" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h4 class="mb-2">Alex Johnson</h4>
                    <p class="text-muted mb-3">Creative Director</p>
                    <p class="text-muted small">
                        With a background in urban art and design, Alex brings the creative vision that defines the BIGGBRODA aesthetic.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="team-card text-center bg-white rounded shadow-sm p-4">
                    <div class="team-image mb-3">
                        <img src="{{ asset('img/team-2.jpg') }}" alt="Co-Founder" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h4 class="mb-2">Sarah Williams</h4>
                    <p class="text-muted mb-3">Operations Director</p>
                    <p class="text-muted small">
                        Sarah's business acumen and passion for fashion have been instrumental in scaling BIGGBRODA from a local brand to a national presence.
                    </p>
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
    
    .story-card, .team-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .story-card:hover, .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .value-item {
        padding: 20px;
        border-radius: 8px;
        transition: background 0.3s ease;
    }
    
    .value-item:hover {
        background: rgba(204, 162, 100, 0.05);
    }
    
    @media (max-width: 768px) {
        .about-hero {
            margin-top: 80px !important;
            text-align: center;
        }
        
        .value-item {
            flex-direction: column;
            text-align: center;
        }
        
        .value-icon {
            margin-bottom: 15px;
            margin-right: 0 !important;
        }
    }
</style>

@include("home.footer")