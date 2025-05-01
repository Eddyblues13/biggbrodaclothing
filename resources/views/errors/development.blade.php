<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Error - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/core-style.css') }}">
    <style>
        .debug-container {
            padding: 2rem;
            background: #fff;
            max-width: 1200px;
            margin: 2rem auto;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        pre {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 5px;
            overflow-x: auto;
        }

        .error-header {
            color: #dc3545;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    @include('home.header')

    <div class="debug-container">
        <h1 class="error-header">Development Mode Error Report</h1>

        <div class="alert alert-danger">
            <h2>{{ $error->getMessage() }}</h2>
            <p class="mb-0">
                In file: <code>{{ $error->getFile() }}</code> (Line: {{ $error->getLine() }})
            </p>
        </div>

        <h3>Stack Trace:</h3>
        <pre>{{ $error->getTraceAsString() }}</pre>

        <h3>Environment Details:</h3>
        <div class="row">
            <div class="col-md-4">
                <ul class="list-group">
                    <li class="list-group-item">
                        PHP Version: {{ phpversion() }}
                    </li>
                    <li class="list-group-item">
                        Laravel Version: {{ app()->version() }}
                    </li>
                    <li class="list-group-item">
                        Environment: {{ app()->environment() }}
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="list-group">
                    <li class="list-group-item">
                        Categories Count: {{ $categories->count() }}
                    </li>
                    <li class="list-group-item">
                        Cart Items: {{ $cartCount }}
                    </li>
                    <li class="list-group-item">
                        Favorites: {{ $favoritesCount }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <i class="fa fa-refresh"></i> Try Again
            </a>
            <button onclick="window.location.reload()" class="btn btn-secondary">
                <i class="fa fa-repeat"></i> Reload Page
            </button>
        </div>
    </div>

    @include('home.footer')
</body>

</html>