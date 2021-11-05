<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') . '.admin' }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.home') }}">
                {{ config('app.name') . '.admin' }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.home')) active @endif" href="{{ route('admin.home') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.offers.index')) active @endif" href="{{ route('admin.offers.index') }}">
                            Товары
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.categories.index')) active @endif" href="{{ route('admin.categories.index') }}">
                            Категории
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.feeds.*')) active @endif" href="{{ route('admin.feeds.index') }}">
                            Фиды
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render() }}

        @yield('content')
    </main>

    @stack('modal')
    @stack('scripts')
</body>
</html>
