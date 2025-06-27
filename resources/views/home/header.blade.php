<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biggbroda Clothing</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>

<body>
    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-container">
            <div class="search-header">
                <h2 class="search-title">Search Products</h2>
                <button class="search-close" id="searchClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="search-input-container">
                <input type="text" class="search-input" id="searchInput" placeholder="What are you looking for?"
                    autocomplete="off">
                <button class="search-submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="search-suggestions">
                <div class="suggestion-category">
                    <h3>Popular Searches</h3>
                    <div class="suggestion-tags">
                        <span class="suggestion-tag">Hoodies</span>
                        <span class="suggestion-tag">Jerseys</span>
                        <span class="suggestion-tag">Shorts</span>
                        <span class="suggestion-tag">New Collection</span>
                        <span class="suggestion-tag">Sale Items</span>
                    </div>
                </div>
                <div class="suggestion-category">
                    <h3>Categories</h3>
                    <div class="suggestion-links">
                        <a href="#" class="suggestion-link">
                            <i class="fas fa-tshirt"></i>
                            <span>Clothing</span>
                        </a>
                        <a href="#" class="suggestion-link">
                            <i class="fas fa-running"></i>
                            <span>Sportswear</span>
                        </a>
                        <a href="#" class="suggestion-link">
                            <i class="fas fa-star"></i>
                            <span>New Arrivals</span>
                        </a>
                        <a href="#" class="suggestion-link">
                            <i class="fas fa-fire"></i>
                            <span>Trending</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Mobile Layout -->
            <div class="d-lg-none d-flex justify-content-between align-items-center w-100 mobile-navbar">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <div class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>

                <a class="navbar-brand" href="#">
                    <img src="{{ asset('img/logo.png')}}" alt="logo" class="logo" width="150" height="50">
                </a>

                <div class="mobile-icons">
                    <a class="nav-link search-trigger" href="#"><i class="fas fa-search"></i></a>
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-bag fs-5"></i>
                        <span id="cartMobileBadge"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count"
                            style="font-size: 0.65em; min-width: 20px; padding: 3px 5px; {{ $cartCount > 0 ? '' : 'display: none;' }}">
                            {{ $cartCount > 0 ? $cartCount : '' }}
                        </span>
                    </a>
                </div>
            </div>

            <!-- Desktop Layout -->
            <div class="d-none d-lg-flex justify-content-between align-items-center w-100 desktop-navbar">
                <div class="navbar-nav nav-left">
                    <a class="nav-link" href="{{url('/')}}">HOME</a>
                    <a class="nav-link" href="#">SHOP</a>
                    <a class="nav-link" href="#">ABOUT</a>
                    <a class="nav-link" href="#">OUR STORE</a>
                </div>

                <a class="navbar-brand mx-auto" href="{{url('/')}}">
                    <img src="{{ asset('img/logo.png')}}" alt="logo" class="logo" width="150" height="50">
                </a>

                <div class="navbar-nav nav-right">
                    <a class="nav-link search-trigger" href="#"><i class="fas fa-search"></i></a>
                    <a class="nav-link" href="#">NGN</a>
                    @guest
                    <a class="nav-link" href="{{ route('login') }}">LOGIN</a>
                    @endguest

                    @auth
                    <a class="nav-link" href="{{ route('profile') }}">PROFILE</a>
                    @endauth


                    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-bag fs-5"></i>
                        <span id="cartBadge"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count"
                            style="font-size: 0.65em; min-width: 20px; padding: 3px 5px; {{ $cartCount > 0 ? '' : 'display: none;' }}">
                            {{ $cartCount > 0 ? $cartCount : '' }}
                        </span>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Collapse -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mobile-nav">
                    <li class="nav-item"><a class="nav-link" href="#">SHOP</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">ABOUT</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">OUR STORE</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">LOGIN</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">WISHLIST</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">NGN</a></li>
                </ul>
            </div>

            <!-- Mobile Menu Collapse (same as before) -->
        </div>
    </nav>