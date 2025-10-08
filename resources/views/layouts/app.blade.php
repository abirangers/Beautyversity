<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kelas Digital') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white text-gray-800">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-10">
                        </a>
                    </div>

                    <nav class="hidden md:flex md:items-center md:space-x-8">
                        <a href="{{ route('home') }}"
                            class="text-sm font-semibold uppercase tracking-wider text-gray-700 hover:text-primary-600 transition">Home</a>
                        <a href="#popular-courses"
                            class="text-sm font-semibold uppercase tracking-wider text-gray-700 hover:text-primary-600 transition">Courses</a>
                        <a href="#latest-articles"
                            class="text-sm font-semibold uppercase tracking-wider text-gray-700 hover:text-primary-600 transition">Articles</a>
                    </nav>

                    <div class="hidden md:flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-sm font-medium text-gray-700 hover:text-primary-600 transition">Dashboard</a>
                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="text-sm font-medium text-gray-700 hover:text-primary-600 transition">Admin</a>
                            @endif
                            <a href="{{ route('logout') }}"
                                class="text-sm font-medium text-gray-700 hover:text-primary-600 transition"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm font-medium text-gray-700 hover:text-primary-600 transition">Log
                                in</a>
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700 transition">Register</a>
                        @endauth
                    </div>

                    <div class="md:hidden">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <main class="flex-grow">
            @yield('content')
        </main>

        <footer style="background-color: #E6B4B8;" class="text-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-bold mb-4">Kelas Digital</h3>
                        <p class="text-sm opacity-90">
                            Menghadirkan informasi terkini, edukasi, dan inspirasi dalam dunia digital. Bersama kami,
                            temukan solusi dan inovasi untuk kebutuhan belajar Anda.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-4">Latest Post</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="opacity-90 hover:opacity-100 transition">Tips Belajar
                                    Efektif</a></li>
                            <li><a href="#" class="opacity-90 hover:opacity-100 transition">Pengenalan Web
                                    Development</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-4">Category</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="opacity-90 hover:opacity-100 transition">Programming</a></li>
                            <li><a href="#" class="opacity-90 hover:opacity-100 transition">Design</a></li>
                            <li><a href="#" class="opacity-90 hover:opacity-100 transition">Marketing</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-4">Newsletter</h3>
                        <p class="text-sm opacity-90 mb-4">
                            Berlangganan untuk mendapatkan informasi terbaru seputar tren, tips, dan ulasan produk
                            digital.
                        </p>
                        <form action="#" method="POST" class="flex">
                            <input type="email" placeholder="Your Email Address"
                                class="w-full px-4 py-2 text-gray-800 rounded-l-md focus:outline-none">
                            <button type="submit" style="background-color: #D18A9B;"
                                class="px-4 py-2 text-white font-semibold rounded-r-md hover:opacity-90 transition shadow-sm hover:shadow-md">
                                Sign Up
                            </button>
                        </form>
                    </div>
                </div>
                <div class="mt-12 border-t border-white border-opacity-20 pt-8 text-center text-sm">
                    <p>Copyright © 2024, Kelas Digital. All Rights Reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
