
@include('home.header')

    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #101320 0%, #1a1f33 100%);
            color: white;
            padding: 20px;
        }
        
        .error-content {
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        
        .error-logo {
            max-width: 150px;
            margin-bottom: 2rem;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 900;
            color: #cca264;
            line-height: 1;
            margin-bottom: 1rem;
        }
        
        .error-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: white;
        }
        
        .error-message {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .search-box {
            max-width: 400px;
            margin: 0 auto 2rem;
        }
        
        .search-box form {
            display: flex;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .search-box input {
            flex: 1;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
        }
        
        .search-box button {
            background: #cca264;
            border: none;
            color: white;
            padding: 0 20px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .search-box button:hover {
            background: #b89155;
        }
        
        .error-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-error {
            background: transparent;
            border: 2px solid #cca264;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-error:hover {
            background: #cca264;
            color: white;
            transform: translateY(-2px);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .error-code {
                font-size: 6rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .error-message {
                font-size: 1rem;
            }
            
            .error-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-error {
                width: 100%;
                max-width: 250px;
                justify-content: center;
            }
        }
        
        @media (max-width: 576px) {
            .error-code {
                font-size: 4rem;
            }
            
            .error-title {
                font-size: 1.25rem;
            }
            
            .search-box {
                max-width: 100%;
            }
        }
    </style>

    <div class="error-page">
        <div class="error-content">
            <img src="{{ asset('img/logo.png') }}" alt="Biggbroda Clothing" class="error-logo">

            <div class="error-code">404</div>
            <h1 class="error-title">Oops! Page Not Found</h1>

            <div class="error-message">
                <p>The page you're looking for doesn't exist or has been moved.</p>
                <p>Let's get you back on track!</p>
            </div>

            <div class="search-box">
                <form action="{{ route('shop') }}" method="GET">
                    <input type="text" name="query" placeholder="Search for products...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="error-actions">
                <a href="{{ url('/') }}" class="btn btn-error">
                    <i class="fas fa-home"></i> Go to Homepage
                </a>
                <a href="{{ route('shop') }}" class="btn btn-error">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
                <a href="#" class="btn btn-error">
                    <i class="fas fa-envelope"></i> Contact Support
                </a>
            </div>
        </div>
    </div>
  @include("home.footer")