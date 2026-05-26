@extends('layouts.app')
@section('title', $ride['origin_city'] . ' → ' . $ride['destination_city'])

@section('content')
<div class="max-w-2xl mx-auto">

    <a href="/" class="text-sm text-green-700 hover:underline mb-4 inline-block">← Back to results</a>

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ $errors->first('error') }}
        </div>
    @endif

    {{-- Ride card --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-6">
        <div class="flex items-center gap-3 text-2xl font-bold mb-1">
            <span>{{ $ride['origin_city'] }}</span>
            <span class="text-green-600">→</span>
            <span>{{ $ride['destination_city'] }}</span>
        </div>
        @if($ride['origin_detail'] || $ride['destination_detail'])
            <p class="text-sm text-gray-400 mb-4">
                {{ $ride['origin_detail'] }}{{ $ride['destination_detail'] ? ' → '.$ride['destination_detail'] : '' }}
            </p>
        @endif

        <div class="grid grid-cols-2 gap-4 text-sm my-4">
            <div class="bg-gray-50 rounded-xl p-3">
                <div class="text-gray-400 text-xs mb-0.5">Date & Time</div>
                <div class="font-semibold">{{ $ride['departure_date'] }}</div>
                <div class="text-gray-600">{{ $ride['departure_time'] }}</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-3">
                <div class="text-gray-400 text-xs mb-0.5">Price per seat</div>
                <div class="font-bold text-green-700 text-xl">{{ number_format($ride['price_per_seat']) }} RWF</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-3">
                <div class="text-gray-400 text-xs mb-0.5">Available seats</div>
                <div class="font-semibold">{{ $ride['available_seats'] }} / {{ $ride['total_seats'] }}</div>
            </div>
            @if($ride['car_model'])
            <div class="bg-gray-50 rounded-xl p-3">
                <div class="text-gray-400 text-xs mb-0.5">Car</div>
                <div class="font-semibold">{{ $ride['car_model'] }}</div>
                @if($ride['car_plate'])
                    <div class="text-gray-400 text-xs">{{ $ride['car_plate'] }}</div>
                @endif
            </div>
            @endif
        </div>

        @if(!empty($ride['tags']))
            <div class="flex flex-wrap gap-1 mt-2">
                @foreach($ride['tags'] as $tag)
                    <span class="bg-green-50 text-green-700 border border-green-200 text-xs px-2 py-0.5 rounded-full">{{ $tag }}</span>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Driver --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mb-6">
        <h2 class="font-semibold text-gray-700 mb-3 text-sm uppercase tracking-wide">Driver</h2>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-lg">
                {{ strtoupper(substr($ride['driver']['full_name'], 0, 1)) }}
            </div>
            <div>
                <div class="font-semibold">{{ $ride['driver']['full_name'] }}</div>
                @if($ride['driver']['average_rating'])
                    <div class="text-xs text-yellow-500">★ {{ number_format($ride['driver']['average_rating'], 1) }} · {{ $ride['driver']['total_trips'] }} trips</div>
                @else
                    <div class="text-xs text-gray-400">New driver</div>
                @endif
            </div>
        </div>
        @if($ride['driver']['bio'])
            <p class="text-sm text-gray-500 mt-3">{{ $ride['driver']['bio'] }}</p>
        @endif
    </div>

    {{-- Book --}}
    @if($ride['available_seats'] > 0)
        @if(session('api_token'))
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h2 class="font-semibold text-gray-700 mb-4">Book this ride</h2>
                <form method="POST" action="/rides/{{ $ride['id'] }}/book" class="flex items-end gap-3">
                    @csrf
                    <input type="hidden" name="ride_id" value="{{ $ride['id'] }}">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Number of seats</label>
                        <input type="number" name="seats_booked" value="1" min="1" max="{{ $ride['available_seats'] }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <button type="submit"
                        class="bg-green-700 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-800 transition">
                        Book now
                    </button>
                </form>
                <p class="text-xs text-gray-400 mt-2">Total price calculated at checkout. Payment via MTN MoMo or Airtel.</p>
            </div>
        @else
            <div class="bg-green-50 border border-green-200 rounded-2xl p-5 text-center">
                <p class="text-sm text-gray-600 mb-3">Log in to book this ride</p>
                <a href="/login" class="bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-green-800 transition inline-block">Login to book</a>
            </div>
        @endif
    @else
        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 text-center text-gray-400 text-sm">
            This ride is fully booked.
        </div>
    @endif

</div>
@endsection
