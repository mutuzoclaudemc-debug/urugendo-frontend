<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct(private ApiService $api) {}

    public function bookings()
    {
        $response = $this->api->myBookings();
        $bookings = $response->successful() ? $response->json() : [];

        return view('dashboard.bookings', ['bookings' => $bookings]);
    }

    public function rides()
    {
        $response = $this->api->myOfferedRides();
        $rides = $response->successful() ? $response->json() : [];

        return view('dashboard.rides', ['rides' => $rides]);
    }

    public function createRide()
    {
        return view('dashboard.create-ride');
    }

    public function storeRide(Request $request)
    {
        $request->validate([
            'origin_city'      => 'required|string',
            'destination_city' => 'required|string',
            'departure_date'   => 'required|date_format:Y-m-d',
            'departure_time'   => 'required|date_format:H:i',
            'total_seats'      => 'required|integer|min:1|max:8',
            'price_per_seat'   => 'required|integer|min:500',
        ]);

        $data = $request->only([
            'origin_city', 'destination_city', 'origin_detail', 'destination_detail',
            'departure_date', 'departure_time', 'total_seats', 'price_per_seat',
            'car_model', 'car_plate',
        ]);

        if ($request->filled('tags')) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $request->input('tags'))));
        }

        $data['total_seats'] = (int) $data['total_seats'];
        $data['price_per_seat'] = (int) $data['price_per_seat'];

        $response = $this->api->createRide($data);

        if ($response->failed()) {
            return back()->withErrors(['error' => $response->json('detail') ?? 'Could not post ride.'])->withInput();
        }

        return redirect('/dashboard/rides')->with('success', 'Ride posted successfully!');
    }

    public function cancelRide(int $id)
    {
        $this->api->cancelRide($id);
        return redirect('/dashboard/rides')->with('success', 'Ride cancelled.');
    }

    public function cancelBooking(int $id)
    {
        $this->api->cancelBooking($id);
        return redirect('/dashboard')->with('success', 'Booking cancelled.');
    }

    public function confirmBooking(int $id)
    {
        $this->api->confirmBooking($id);
        return redirect('/dashboard')->with('success', 'Booking confirmed!');
    }

    public function bookRide(Request $request)
    {
        $request->validate([
            'ride_id'      => 'required|integer',
            'seats_booked' => 'required|integer|min:1',
        ]);

        $response = $this->api->createBooking($request->only('ride_id', 'seats_booked'));

        if ($response->failed()) {
            return back()->withErrors(['error' => $response->json('detail') ?? 'Booking failed.']);
        }

        return redirect('/dashboard')->with('success', 'Seat(s) booked! Check your bookings.');
    }
}
