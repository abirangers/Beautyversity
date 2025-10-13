<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Kelas Digital'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome for social icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-rich-text::styles theme="richtextlaravel" />
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col">

        <header>
            <!-- Top Bar -->
            <div class="bg-gray-800 text-white text-sm">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center py-2">
                    <div>
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>Bandung - Jawa Barat, Indonesia</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="hover:text-primary-400 transition"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-primary-400 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-primary-400 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-primary-400 transition"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <!-- Main Header (Branding) -->
            <div class="bg-white py-6">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-center items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-12">
                    </a>
                </div>
            </div>

            <!-- Navigation Bar (Sticky on Scroll) -->
            <nav id="main-header" class="bg-white border-b border-gray-200 relative transition-all duration-300">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Mobile Menu Button -->
                        <div class="md:hidden">
                            <button id="mobile-menu-button" class="text-gray-600 p-2 rounded-md">
                                <i class="fas fa-bars h-6 w-6"></i>
                            </button>
                        </div>

                        <!-- Desktop Navigation Links -->
                        <div class="hidden md:flex md:flex-col md:items-center md:space-y-2">

                            <div class="flex flex-wrap justify-center gap-x-8 gap-y-2 mt-1">
                                <a href="{{ route('home') }}"
                                    class="nav-link text-gray-700 text-sm font-semibold uppercase tracking-wider hover:text-primary-600 transition">
                                    Home
                                </a>
                                @if (isset($articleCategories))
                                    @foreach ($articleCategories as $category)
                                        <a href="{{ route('article.category', $category->slug) }}"
                                            class="nav-link text-gray-700 text-sm font-semibold uppercase tracking-wider hover:text-primary-600 transition whitespace-nowrap">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Search and Auth Links -->
                        <div class="flex items-center space-x-4">
                            <form action="{{ route('search') }}" method="GET" class="hidden md:flex items-center bg-gray-100 rounded-full px-4 py-2 focus-within:ring-2 focus-within:ring-primary-500">
                                <label for="header-search" class="sr-only">Cari</label>
                                <input
                                    type="search"
                                    id="header-search"
                                    name="q"
                                    class="bg-transparent focus:outline-none text-sm text-gray-600 placeholder-gray-400 w-40"
                                    placeholder="Cari kelas atau artikel..."
                                >
                                <button type="submit" class="text-gray-500 hover:text-primary-600 transition">
                                    <i class="fas fa-search h-4 w-4"></i>
                                </button>
                            </form>
                            <a href="{{ route('search') }}" class="md:hidden text-gray-600 hover:text-primary-600">
                                <i class="fas fa-search h-5 w-5"></i>
                            </a>
                            @auth
                            <!-- kalo admin ke /admin, kalo user ke /dashboard -->
                                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                                    class="auth-link text-gray-700 text-sm font-medium hover:text-primary-600 transition">Dashboard</a>
                            @else
                                {{-- <a href="{{ route('login') }}"
                                    class="auth-link text-gray-700 text-sm font-medium hover:text-primary-600 transition">Log
                                    in</a>
                                <a href="{{ route('register') }}" id="register-button"
                                    class="bg-primary-600 text-white px-4 py-2 text-sm font-medium rounded-md hover:opacity-90 transition-colors duration-300">Register</a> --}}
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay" class="hidden fixed inset-0 bg-white z-50 p-4">
            <div class="flex justify-between items-center mb-8">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-10">
                </a>
                <button id="mobile-menu-close-button" class="text-gray-800">
                    <i class="fas fa-times h-6 w-6"></i>
                </button>
            </div>
            <form action="{{ route('search') }}" method="GET" class="mb-6">
                <label for="mobile-search" class="sr-only">Cari</label>
                <div class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2">
                    <i class="fas fa-search text-gray-400"></i>
                    <input
                        type="search"
                        id="mobile-search"
                        name="q"
                        class="flex-1 focus:outline-none text-sm text-gray-700 placeholder-gray-400"
                        placeholder="Cari kelas atau artikel..."
                    >
                </div>
            </form>
            <nav class="flex flex-col space-y-4">
                @if (isset($articleCategories))
                    @foreach ($articleCategories as $category)
                        <a href="{{ route('article.category', $category->slug) }}"
                            class="text-gray-800 font-semibold uppercase tracking-wider hover:text-primary-60 transition">{{ $category->name }}</a>
                    @endforeach
                @endif
            </nav>
        </div>

        <main class="flex-grow">
            @yield('content')
        </main>

        <footer style="background-color: #E6B4B8;" class="text-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Footer content can be added here -->
                </div>
                <div class="mt-12 border-t border-white border-opacity-20 pt-8 text-center text-sm">
                    <p>Copyright © 2024, Kelas Digital. All Rights Reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
