<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title'){{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" @class(['nav-link', 'dropdown-toggle', 'text-primary' => checkSegment(1, 'users', true) || checkSegment(1, 'products', true)])>
                            Masterfile
                        </a>
                        <ul class="dropdown-menu">
                            <li><a @class(['bg-primary text-white' => checkSegment(1, 'users', true), 'dropdown-item']) href="/users">Users Masterfile</a></li>
                            <li><a @class(['bg-primary text-white' => checkSegment(1, 'products', true), 'dropdown-item']) href="/products">Products Masterfile</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a @class(['nav-link', 'dropdown-toggle', 'text-primary' => checkSegment(1, 'orders', true)]) href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Modules
                        </a>
                        <ul class="dropdown-menu">
                            <li><a @class(['bg-primary text-white' => checkSegment(1, 'orders', true), 'dropdown-item']) href="/orders">Orders</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    {{-- Scripts --}}
    <script src="{{ mix('js/app.js') }}"></script>

    {{-- Custom Script --}}
    <script src="{{ asset('js/custom_script.js') }}"></script>

    @yield('scripts')
</body>

</html>
