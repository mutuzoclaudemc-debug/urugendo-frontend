<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} — @yield('title', 'Ridesharing Rwanda')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 text-gray-900">

{{-- Nav --}}
<nav class="bg-green-700 text-white shadow-md">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="/" class="text-xl font-bold tracking-tight">🇷🇼 Urugendo</a>
        <div class="flex items-center gap-4 text-sm font-medium">
            <a href="/" class="hover:text-green-200 transition">Find Rides</a>
            @if(session('api_token'))
                <a href="/dashboard" class="hover:text-green-200 transition">My Bookings</a>
                <a href="/dashboard/rides" class="hover:text-green-200 transition">My Rides</a>
                <a href="/dashboard/rides/new" class="bg-white text-green-700 px-3 py-1 rounded-full hover:bg-green-100 transition">+ Post Ride</a>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-green-200 transition">Logout</button>
                </form>
            @else
                <a href="/login" class="hover:text-green-200 transition">Login</a>
                <a href="/register" class="bg-white text-green-700 px-3 py-1 rounded-full hover:bg-green-100 transition">Register</a>
            @endif
        </div>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
    <div class="max-w-5xl mx-auto px-4 mt-4">
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    </div>
@endif
@if(session('error'))
    <div class="max-w-5xl mx-auto px-4 mt-4">
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    </div>
@endif

{{-- Main --}}
<main class="max-w-5xl mx-auto px-4 py-8">
    @yield('content')
</main>

<footer class="text-center text-xs text-gray-400 py-8 mt-8">
    Urugendo &mdash; Rwanda Ridesharing &copy; {{ date('Y') }}
</footer>

</body>
</html>
