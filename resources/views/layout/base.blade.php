<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/images/logo.jpg" type="image/x-icon">
    <title>SmartFood | Admin</title>
    @vite(['resources/css/app.css'])
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        .layout {
            display: flex;
            flex: 1;
            min-height: 100vh;
        }

        .sidebar {
            width: 16rem;
            flex-shrink: 0;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding-top: 2rem;
        }

        .content {
            flex: 1;
            padding: 1.5rem;
        }
    </style>
</head>
<body class="bg-[#18082f] text-white">

    <!-- Header Section -->
    <header class="bg-white/10 backdrop-blur-lg shadow-md">
        <nav class="flex items-center justify-between p-4">
            <!-- Logo and Branding -->
            <div class="flex items-center space-x-2">
                <img src="/images/logo.jpg" alt="SmartFood logo" class="h-12 w-12 object-cover rounded-full">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold text-white">
                    <span class="text-[#ef6002]">Smart</span>Food
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-4">
                @auth('admin')
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <button class="p-2 bg-[#ef6002] rounded-md hover:bg-white hover:text-[#ef6002] transition duration-300">
                            Logout
                        </button>
                    </form>
                @endauth

                @guest('admin')
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.login') }}"
                           class="p-2 bg-[#18082f] text-white rounded-md hover:bg-opacity-60 transition duration-300">
                            Login
                        </a>
                        <a href="{{ route('admin.register') }}"
                           class="p-2 bg-white/10 text-white rounded-md hover:bg-opacity-80 transition duration-300">
                            Register
                        </a>
                    </div>
                @endguest
            </div>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-toggle" class="block md:hidden p-2 text-white" aria-label="Toggle mobile menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </nav>
    </header>

    <!-- Main Layout -->
    <div class="layout">

        <!-- Sidebar -->
        @auth('admin')
        <aside class="sidebar hidden md:block">
            <ul class="flex text-center flex-col space-y-4 mx-4">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                       class="block p-2 bg-white/20 text-white rounded hover:text-gray-200 transition duration-300">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.menus') }}"
                       class="block p-2 bg-white/20 text-white rounded hover:text-gray-200 transition duration-300">
                        Groceries
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}"
                       class="block p-2 bg-white/20 text-white rounded hover:text-gray-200 transition duration-300">
                        Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pending-users') }}"
                       class="block p-2 bg-white/20 text-white rounded hover:text-gray-200 transition duration-300">
                        Pending Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pending-codes') }}"
                       class="block p-2 bg-white/20 text-white rounded hover:text-gray-200 transition duration-300">
                        Pending Codes
                    </a>
                </li>
            </ul>
        </aside>
        @endauth

        <!-- Main Content -->
        <main class="content">
            @error('error')
                <p class="text-center p-2">{{ $message }}</p>
            @enderror

            @if(session('success'))
                <p class="text-center p-2">{{ session('success') }}</p>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Footer Section -->
    @auth('admin')
    <footer class="bg-white/10 backdrop-blur-lg p-4 text-center">
        &copy; {{ date('Y') }} SmartFood | Admins.
    </footer>
    @endauth

    <!-- Mobile Navigation -->
    <nav id="mobile-nav" class="fixed top-0 left-0 w-full h-screen bg-[#18082f] text-white hidden z-50 pt-10">
        <ul class="flex flex-col items-center justify-center space-y-6">
            @auth('admin')
                <li><a href="{{ route('admin.dashboard') }}" class="text-lg">Dashboard</a></li>
                <li><a href="{{ route('admin.menus') }}" class="text-lg">Menu</a></li>
                <li><a href="{{ route('admin.orders') }}" class="text-lg">Orders</a></li>
                <li><a href="{{ route('admin.pending-users') }}" class="text-lg">Pending Users</a></li>
                <li><a href="{{ route('admin.pending-codes') }}" class="text-lg">Pending Codes</a></li>

                <li>
                    <form action="{{ route('admin.logout') }}" method="post" class="w-full text-center">
                        @csrf
                        <button class="p-2 bg-[#ef6002] rounded-md hover:bg-white hover:text-[#ef6002] transition duration-300">
                            Logout
                        </button>
                    </form>
                </li>
            @endauth

            @guest('admin')
                <li><a href="{{ route('admin.register') }}" class="text-lg">Register</a></li>
                <li><a href="{{ route('admin.login') }}" class="text-lg">Login</a></li>
            @endguest
        </ul>
        <button id="close-mobile-nav" class="absolute top-4 right-4 p-2" aria-label="Close mobile menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </nav>

    <script>
        const mobileNav = document.getElementById('mobile-nav')
        const toggleButton = document.getElementById('mobile-menu-toggle')
        const closeButton = document.getElementById('close-mobile-nav')

        toggleButton.addEventListener('click', () => {
            mobileNav.classList.toggle('hidden')
        });

        closeButton.addEventListener('click', () => {
            mobileNav.classList.add('hidden')
        });
    </script>
</body>
</html>
