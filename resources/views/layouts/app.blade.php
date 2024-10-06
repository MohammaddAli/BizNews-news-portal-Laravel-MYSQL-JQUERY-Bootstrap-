@if (Auth::guard('employee')->user())
    <!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Simple Laravel 10 User Roles and Permissions - AllPHPTricks.com</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>

    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    {{-- <a class="navbar-brand" href="{{ url('/') }}">
                    AllPHPTricks.com
                </a> --}}
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                @canany(['role-create', 'role-edit', 'role-delete'])
                                    <li><a class="nav-link" href="{{ route('employee.roles.index') }}">Roles</a></li>
                                @endcanany
                                @canany(['CRUD employee'])
                                    <li><a class="nav-link" href="{{ route('employee.employees.index') }}">Employees</a></li>
                                @endcanany
                                @canany(['write article', 'read article', 'update article', 'delete article'])
                                    <li><a class="nav-link" href="{{ route('employee.articles.index') }}">News Articles</a>
                                    </li>
                                    @endcanany @canany(['CRUD category'])
                                    <li><a class="nav-link" href="{{ route('employee.categories.index') }}">Categories</a></li>
                                    @endcanany @canany(['create article', 'edit article', 'delete article'])
                                    <li><a class="nav-link" href="{{ route('employee.article-images.create') }}">Article
                                            Images</a>
                                    </li>
                                @endcanany
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::guard('employee')->user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('employee.logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('employee.logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-12">

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success text-center" role="alert">
                                    {{ $message }}
                                </div>
                            @endif

                            {{-- <h3 class="text-center mt-3 mb-3">Simple Laravel 10 User Roles and Permissions - <a
                            href="https://www.allphptricks.com/">AllPHPTricks.com</a></h3> --}}
                            @yield('content')

                            {{-- <div class="row justify-content-center text-center mt-3">
                        <div class="col-md-12">
                            <p>Back to Tutorial:
                                <a href="https://www.allphptricks.com/simple-laravel-10-user-roles-and-permissions/"><strong>Tutorial
                                        Link</strong></a>
                            </p>
                            <p>
                                For More Web Development Tutorials Visit: <a
                                    href="https://www.allphptricks.com/"><strong>AllPHPTricks.com</strong></a>
                            </p>
                        </div>
                    </div> --}}


                        </div>
                    </div>
                </div>
            </main>
        </div>
    @else
        <!DOCTYPE html>
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <title>{{ config('app.name', 'Laravel') }}</title>

            <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

            <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        </head>

        <body class="font-sans antialiased">
            {{-- <div class="min-h-screen bg-gray-100"> --}}
            @include('layouts.navigation')

            {{-- <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main> --}}
            {{-- </div> --}}
        </body>

        </html>
@endif
