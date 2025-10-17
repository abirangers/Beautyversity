<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Kelas Digital')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-rich-text::styles theme="richtextlaravel" />
</head>

<body class="h-full font-sans">
    <div x-data="{ open: false }" class="flex min-h-screen">
        <aside class="w-64 flex-shrink-0 bg-white border-r border-gray-200 flex flex-col">
            <div class="h-20 flex items-center justify-center px-6 border-b border-gray-200">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-10">
                </a>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-6">
                <!-- Dashboard -->
                <div>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-tachometer-alt mr-3 text-base"></i>
                        Dashboard
                    </a>
                </div>

                <!-- Course Management Group - Hidden for Content Manager -->
                @unless(auth()->user()->hasRole('content-manager'))
                <div x-data="{ 
                    open: localStorage.getItem('course-group-open') !== 'false' 
                }">
                    <button @click="open = !open; localStorage.setItem('course-group-open', open)" 
                        class="flex items-center justify-between w-full px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider hover:text-gray-700 transition-colors duration-200">
                        <span>Course Management</span>
                        <i class="fas fa-chevron-down transition-transform duration-200" 
                           :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" 
                         x-collapse
                         class="space-y-1 mt-2">
                        <a href="{{ route('admin.courses.index') }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.courses.*') ? 'bg-primary-100 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-book-open mr-3 text-base"></i>
                            Manage Courses
                        </a>
                        <a href="{{ route('admin.course-categories.index') }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.course-categories.*') ? 'bg-primary-100 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-sitemap mr-3 text-base"></i>
                            Course Categories
                        </a>
                        <a href="{{ route('admin.lessons.index') }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.lessons.*') ? 'bg-primary-100 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-list mr-3 text-base"></i>
                            Manage Lessons
                        </a>
                    </div>
                </div>
                @endunless

                <!-- Content Management Group - Hidden for Instructor -->
                @unless(auth()->user()->hasRole('instructor'))
                <div x-data="{ 
                    open: localStorage.getItem('content-group-open') !== 'false' 
                }">
                    <button @click="open = !open; localStorage.setItem('content-group-open', open)" 
                        class="flex items-center justify-between w-full px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider hover:text-gray-700 transition-colors duration-200">
                        <span>Content Management</span>
                        <i class="fas fa-chevron-down transition-transform duration-200" 
                           :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" 
                         x-collapse
                         class="space-y-1 mt-2">
                        <a href="{{ route('admin.articles.index') }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.articles.*') ? 'bg-primary-100 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-file-alt mr-3 text-base"></i>
                            Manage Articles
                        </a>
                        <a href="{{ route('admin.article-categories.index') }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.article-categories.*') ? 'bg-primary-100 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-folder-open mr-3 text-base"></i>
                            Article Categories
                        </a>
                        <a href="{{ route('admin.tags.index') }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.tags.*') ? 'bg-primary-100 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-tags mr-3 text-base"></i>
                            Tags
                        </a>
                    </div>
                </div>
                @endunless

                <!-- System Management Group - Hidden for Instructor and Content Manager -->
                @unless(auth()->user()->hasRole(['instructor', 'content-manager']))
                <div x-data="{ 
                    open: localStorage.getItem('system-group-open') !== 'false' 
                }">
                    <button @click="open = !open; localStorage.setItem('system-group-open', open)" 
                        class="flex items-center justify-between w-full px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider hover:text-gray-700 transition-colors duration-200">
                        <span>System Management</span>
                        <i class="fas fa-chevron-down transition-transform duration-200" 
                           :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" 
                         x-collapse
                         class="space-y-1 mt-2">
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-primary-100 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-users mr-3 text-base"></i>
                            Manage Users
                        </a>
                        <a href="{{ route('admin.payments.index') }}"
                            class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.payments.*') ? 'bg-primary-100 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-credit-card mr-3 text-base"></i>
                            Manage Payments
                        </a>
                    </div>
                </div>
                @endunless
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex justify-between items-center h-20 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-bold text-gray-900">
                        @yield('title')
                    </h1>
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center space-x-2 text-left">
                            <img class="h-10 w-10 rounded-full object-cover"
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=E6B4B8&color=333333"
                                alt="User Avatar">
                            <div>
                                <span class="font-semibold text-gray-800 text-sm">{{ Auth::user()->name }}</span>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-500 text-sm transition-transform duration-200" 
                               :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                            <a href="{{ route('home') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-150">
                                <div class="flex items-center">
                                    View Site
                                </div>
                            </a>
                            <a href="#"
                                @click.prevent="document.getElementById('logout-form').submit()"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-150">
                                <div class="flex items-center">
                                    Logout
                                </div>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
