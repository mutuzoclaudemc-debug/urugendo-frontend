@extends('layouts.app')
@section('title', 'Post a Ride')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="/dashboard/rides" class="text-sm text-green-700 hover:underline mb-4 inline-block">← My Rides</a>
    <h1 class="text-2xl font-bold mb-6">Post a ride</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ $errors->first('error') ?? $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/dashboard/rides/new" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From (city) *</label>
                <input type="text" name="origin_city" value="{{ old('origin_city') }}" placeholder="Kigali"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To (city) *</label>
                <input type="text" name="destination_city" value="{{ old('destination_city') }}" placeholder="Musanze"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pickup detail</label>
                <input type="text" name="origin_detail" value="{{ old('origin_detail') }}" placeholder="e.g. Nyabugogo bus park"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Drop-off detail</label>
                <input type="text" name="destination_detail" value="{{ old('destination_detail') }}" placeholder="e.g. Musanze town centre"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Departure date *</label>
                <input type="date" name="departure_date" value="{{ old('departure_date') }}"
                    min="{{ date('Y-m-d') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Departure time *</label>
                <input type="time" name="departure_time" value="{{ old('departure_time') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total seats *</label>
                <input type="number" name="total_seats" value="{{ old('total_seats', 3) }}" min="1" max="8"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price per seat (RWF) *</label>
                <input type="number" name="price_per_seat" value="{{ old('price_per_seat') }}" min="500" placeholder="e.g. 3000"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <p class="text-xs text-gray-400 mt-1">Minimum 500 RWF</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Car model</label>
                <input type="text" name="car_model" value="{{ old('car_model') }}" placeholder="e.g. Toyota Corolla"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plate number</label>
                <input type="text" name="car_plate" value="{{ old('car_plate') }}" placeholder="e.g. RAA 123A"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tags <span class="text-gray-400">(comma-separated)</span></label>
            <input type="text" name="tags" value="{{ old('tags') }}" placeholder="e.g. music, AC, no smoking"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <button type="submit"
            class="w-full bg-green-700 text-white py-2 rounded-lg font-medium hover:bg-green-800 transition">
            Post ride
        </button>
    </form>
</div>
@endsection
