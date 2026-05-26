@extends('layouts.app')
@section('title', 'My Rides')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">My Offered Rides</h1>
    <a href="/dashboard/rides/new" class="bg-green-700 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-800 transition">+ Post a ride</a>
</div>

@if(count($rides) === 0)
    <div class="text-center py-16 text-gray-400">
        <div class="text-5xl mb-4">🚗</div>
        <p class="text-lg font-medium text-gray-500">You haven't posted any rides yet</p>
        <a href="/dashboard/rides/new" class="mt-3 inline-block text-green-700 hover:underline text-sm">Post your first ride</a>
    </div>
@else
    <div class="space-y-4">
        @foreach($rides as $ride)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2 font-bold text-lg">
                        <span>{{ $ride['origin_city'] }}</span>
                        <span class="text-green-600">→</span>
                        <span>{{ $ride['destination_city'] }}</span>
                    </div>
                    <div class="text-sm text-gray-500 mt-1 flex flex-wrap gap-3">
                        <span>📅 {{ $ride['departure_date'] }} {{ $ride['departure_time'] }}</span>
                        <span>💺 {{ $ride['available_seats'] }}/{{ $ride['total_seats'] }} seats left</span>
                        @if($ride['car_model'])
                            <span>🚗 {{ $ride['car_model'] }}</span>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-green-700">{{ number_format($ride['price_per_seat']) }} RWF/seat</div>
                    @if($ride['is_active'])
                        <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700 border border-green-200">Active</span>
                    @else
                        <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 border border-gray-200">Cancelled</span>
                    @endif
                </div>
            </div>

            @if($ride['is_active'])
                <div class="mt-4 flex gap-2">
                    <a href="/rides/{{ $ride['id'] }}" class="text-sm text-green-700 border border-green-200 px-3 py-1 rounded-lg hover:bg-green-50 transition">
                        View
                    </a>
                    <form method="POST" action="/dashboard/rides/{{ $ride['id'] }}/cancel">
                        @csrf
                        <button type="submit"
                            class="text-sm text-red-600 border border-red-200 px-3 py-1 rounded-lg hover:bg-red-50 transition"
                            onclick="return confirm('Cancel this ride? All passengers will be notified.')">
                            Cancel ride
                        </button>
                    </form>
                </div>
            @endif
        </div>
        @endforeach
    </div>
@endif
@endsection
