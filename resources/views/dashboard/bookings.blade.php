@extends('layouts.app')
@section('title', 'My Bookings')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">My Bookings</h1>
    <a href="/" class="text-sm text-green-700 hover:underline">Find more rides →</a>
</div>

@if(count($bookings) === 0)
    <div class="text-center py-16 text-gray-400">
        <div class="text-5xl mb-4">🎫</div>
        <p class="text-lg font-medium text-gray-500">No bookings yet</p>
        <a href="/" class="mt-3 inline-block text-green-700 hover:underline text-sm">Search for a ride</a>
    </div>
@else
    <div class="space-y-4">
        @foreach($bookings as $booking)
        @php
            $statusColors = [
                'pending'   => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                'confirmed' => 'bg-green-100 text-green-700 border-green-200',
                'cancelled' => 'bg-red-100 text-red-600 border-red-200',
                'completed' => 'bg-blue-100 text-blue-700 border-blue-200',
            ];
            $color = $statusColors[$booking['status']] ?? 'bg-gray-100 text-gray-600 border-gray-200';
        @endphp
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2 font-bold text-lg">
                        <span>{{ $booking['ride']['origin_city'] }}</span>
                        <span class="text-green-600">→</span>
                        <span>{{ $booking['ride']['destination_city'] }}</span>
                    </div>
                    <div class="text-sm text-gray-500 mt-1 flex gap-3">
                        <span>📅 {{ $booking['ride']['departure_date'] }} {{ $booking['ride']['departure_time'] }}</span>
                        <span>💺 {{ $booking['seats_booked'] }} seat{{ $booking['seats_booked'] > 1 ? 's' : '' }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-green-700">{{ number_format($booking['total_price']) }} RWF</div>
                    <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full border {{ $color }}">
                        {{ ucfirst($booking['status']) }}
                    </span>
                </div>
            </div>

            @if($booking['status'] === 'pending')
                <div class="mt-4 flex gap-2">
                    <form method="POST" action="/dashboard/bookings/{{ $booking['id'] }}/cancel">
                        @csrf
                        <button type="submit"
                            class="text-sm text-red-600 border border-red-200 px-3 py-1 rounded-lg hover:bg-red-50 transition"
                            onclick="return confirm('Cancel this booking?')">
                            Cancel booking
                        </button>
                    </form>
                </div>
            @endif
        </div>
        @endforeach
    </div>
@endif
@endsection
