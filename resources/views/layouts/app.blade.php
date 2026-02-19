<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@stack('styles')

</head>

<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md px-4 py-3 flex justify-between items-center sticky top-0 z-50">
        <div class="font-bold text-lg text-gray-800">Ujian Online</div>

        <div class="flex items-center gap-4">
            @auth
                <div class="relative group">
                    <button class="flex items-center gap-2 focus:outline-none">
                        <svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                        <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                    </button>

                    <div class="absolute right-0 mt-2 w-32 bg-white shadow-lg rounded-md opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-blue-600 font-medium">Login</a>
            @endauth
        </div>
    </nav>

    <!-- Content -->
    <main class="container mx-auto mt-6 px-4 md:px-0">
        @yield('content')
    </main>

</body>
</html>
