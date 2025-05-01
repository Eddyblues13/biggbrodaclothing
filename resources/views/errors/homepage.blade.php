<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site Maintenance - {{ config('app.name') }}</title>

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/core-style.css') }}">
    <style>
        .error-container {
            background: #f9f9f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem;
        }

        .error-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .error-logo {
            max-width: 200px;
            margin: 0 auto 2rem;
        }

        .error-code {
            color: #e44d2e;
            font-size: 4rem;
            margin: 1rem 0;
        }

        .error-actions {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-error {
            background: #e44d2e;
            color: white !important;
            padding: 12px 25px;
            border-radius: 25px;
            text-transform: uppercase;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-error:hover {
            background: #d14023;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-content">
            <img src="{{ asset('assets/img/core-img/logo.png') }}" alt="Logo" class="error-logo">

            <h1>We're Working to Improve Your Experience</h1>

            <div class="error-message">
                <p class="text-muted mb-4">
                    Oops! It seems we're having trouble loading the homepage right now. Our team has been notified
                    and is working to resolve the issue promptly.
                </p>

                <div class="error-details">
                    <p class="text-muted small mb-0">
                        Error Reference: HP{{ now()->format('YmdHi') }}<br>
                        Last Update: {{ now()->format('F j, Y H:i A') }}
                    </p>
                </div>

                <div class="error-actions mt-5">
                    <a href="{{ url('/') }}" class="btn-error">
                        <i class="fa fa-refresh mr-2"></i>Try Again
                    </a>
                    <a href="" class="btn-error">
                        <i class="fa fa-envelope mr-2"></i>Contact Support
                    </a>
                </div>

                <div class="status-updates mt-4">
                    <p class="small text-muted">
                        Follow our status page for updates:
                        <a href="#" class="text-primary">Service Status</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Footer -->
    <footer class="fixed-bottom bg-light py-3 d-none d-md-block">
        <div class="container text-center">
            <p class="mb-0 small text-muted">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                <span class="mx-2">|</span>
                Error Code: 5XX-HP
            </p>
        </div>
    </footer>
</body>

</html>