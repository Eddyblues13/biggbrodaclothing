{{-- @if(View::exists('home.header'))
@include('home.header')
@endif --}}

<body>
    <div class="error-page">
        <div class="error-content">
            <img src="{{ asset('assets/img/core-img/logo.png') }}" alt="Logo" class="error-logo">

            <div class="error-code">404</div>
            <h1 class="error-title">Oops! Page Not Found</h1>

            <div class="error-message">
                <p>The page you're looking for doesn't exist or has been moved.</p>
                <p>Let's get you back on track!</p>
            </div>

            <div class="search-box">
                <form action="" method="GET">
                    <input type="text" name="query" placeholder="Search for products...">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <div class="error-actions">
                <a href="{{ url('/') }}" class="btn btn-error">
                    <i class="fa fa-home"></i> Go to Homepage
                </a>
                <a href="" class="btn btn-error">
                    <i class="fa fa-shopping-bag"></i> Continue Shopping
                </a>
                <a href="" class="btn btn-error">
                    <i class="fa fa-envelope"></i> Contact Support
                </a>
            </div>


        </div>
    </div>

    <!-- Include your footer if needed -->
    @if(View::exists('home.footer'))
    @include('home.footer')
    @endif

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
</body>

</html>