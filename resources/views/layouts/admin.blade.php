<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Kelas Digital')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-gray-800 text-white flex-shrink-0">
            <div class="p-4 border-b border-gray-700">
                <h1 class="text-xl font-bold">Admin Kelas Digital</h1>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.courses.index') }}"
                    class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.courses.*') ? 'bg-gray-700' : '' }}">
                    Manage Courses
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                    Manage Users
                </a>
                <a href="{{ route('admin.lessons.index') }}"
                    class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.lessons.*') ? 'bg-gray-700' : '' }}">
                    Manage Lessons
                </a>
                <a href="{{ route('admin.payments.index') }}"
                    class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.payments.*') ? 'bg-gray-700' : '' }}">
                    Manage Payments
                </a>
                <a href="{{ route('admin.articles.index') }}"
                    class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.articles.*') ? 'bg-gray-700' : '' }}">
                    Manage Articles
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-md">
                <div class="flex justify-between items-center p-4">
                    <h1 class="text-xl font-semibold">@yield('title')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Halo, {{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}" class="text-gray-600 hover:text-gray-900"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
