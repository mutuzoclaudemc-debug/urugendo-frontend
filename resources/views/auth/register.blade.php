@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-center">Create your account</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/register" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full name</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Amina Uwase"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone number</label>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+250788123456"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
            <p class="text-xs text-gray-400 mt-1">Rwanda format: +2507XXXXXXXX</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-gray-400">(optional)</span></label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm password</label>
            <input type="password" name="password_confirmation"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>
        <button type="submit"
            class="w-full bg-green-700 text-white py-2 rounded-lg font-medium hover:bg-green-800 transition">
            Create account
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-4">
        Already have an account? <a href="/login" class="text-green-700 font-medium hover:underline">Login</a>
    </p>
</div>
@endsection
