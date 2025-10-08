<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kelas Digital - Platform Belajar Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="text-primary-600 text-xl font-bold">
                    <img src="{{ asset('logo.webp') }}" alt="Kelas Digital" class="h-11 inline-block">
                </a>
                <nav class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-600">Halo, {{ Auth::user()->name }}</span>
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">Dashboard</a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">Dashboard</a>
                        @endif
                        <a href="{{ route('logout') }}"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        {{-- <a href="{{ route('login') }}"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">Daftar</a> --}}
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 Beautyversity. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
</body>

</html>
