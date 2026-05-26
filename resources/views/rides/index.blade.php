@extends('layouts.app')
@section('title', 'Find a Ride')

@section('content')

{{-- Hero / Search --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
    <h1 class="text-2xl font-bold mb-1">Find a ride across Rwanda</h1>
    <p class="text-gray-500 text-sm mb-5">Search shared rides between cities — affordable and convenient.</p>

    <form method="GET" action="/" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <input type="text" name="origin" value="{{ $filters['origin'] ?? '' }}" placeholder="From (e.g. Kigali)"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

        <input type="text" name="destination" value="{{ $filters['destination'] ?? '' }}" placeholder="To (e.g. Musanze)"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

        <input type="date" name="date" value="{{ $filters['date'] ?? '' }}"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

        <input type="number" name="min_seats" value="{{ $filters['min_seats'] ?? 1 }}" min="1" placeholder="Seats needed"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

        <button type="submit"
            class="bg-green-700 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-green-800 transition">
            Search
        </button>
    </form>
</div>

{{-- Results --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="font-semibold text-gray-700">
        @if($results['total'] > 0)
            {{ $results['total'] }} ride{{ $results['total'] > 1 ? 's' : '' }} found
        @else
            No rides found
        @endif
    </h2>
    @if(session('api_token'))
        <a href="/dashboard/rides/new" class="text-sm text-green-700 font-medium hover:underline">+ Post a ride</a>
    @endif
</div>

@if(count($results['results']) > 0)
    <div class="space-y-4">
        @foreach($results['results'] as $ride)
        <a href="/rides/{{ $ride['id'] }}" class="block bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-green-300 transition p-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2 text-lg font-bold text-gray-900">
                        <span>{{ $ride['origin_city'] }}</span>
                        <span class="text-green-600">→</span>
                        <span>{{ $ride['destination_city'] }}</span>
                    </div>
                    @if($ride['origin_detail'] || $ride['destination_detail'])
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $ride['origin_detail'] }} {{ $ride['destination_detail'] ? '→ '.$ride['destination_detail'] : '' }}
                        </p>
                    @endif
                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                        <span>📅 {{ $ride['departure_date'] }} at {{ $ride['departure_time'] }}</span>
                        <span>💺 {{ $ride['available_seats'] }} seat{{ $ride['available_seats'] > 1 ? 's' : '' }} left</span>
                        @if($ride['car_model'])
                            <span>🚗 {{ $ride['car_model'] }}</span>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-green-700">{{ number_format($ride['price_per_seat']) }} <span class="text-sm font-normal">RWF</span></div>
                    <div class="text-xs text-gray-400 mt-0.5">per seat</div>
                    <div class="text-xs text-gray-500 mt-1">by {{ $ride['driver']['full_name'] }}</div>
                </div>
            </div>

            @if(!empty($ride['tags']))
                <div class="flex flex-wrap gap-1 mt-3">
                    @foreach($ride['tags'] as $tag)
                        <span class="bg-green-50 text-green-700 border border-green-200 text-xs px-2 py-0.5 rounded-full">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif
        </a>
        @endforeach
    </div>
@else
    <div class="text-center py-16 text-gray-400">
        <div class="text-5xl mb-4">🚗</div>
        <p class="text-lg font-medium text-gray-500">No rides available</p>
        <p class="text-sm mt-1">Try different dates or cities, or
            @if(session('api_token'))
                <a href="/dashboard/rides/new" class="text-green-700 hover:underline">post your own ride</a>.
            @else
                <a href="/register" class="text-green-700 hover:underline">register to post a ride</a>.
            @endif
        </p>
    </div>
@endif

@endsection
