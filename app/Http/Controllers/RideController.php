<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function __construct(private ApiService $api) {}

    public function index(Request $request)
    {
        $params = $request->only('origin', 'destination', 'date', 'min_seats', 'max_price');
        $response = $this->api->searchRides($params);
        $results = $response->successful() ? $response->json() : ['total' => 0, 'results' => []];

        return view('rides.index', [
            'results' => $results,
            'filters' => $params,
        ]);
    }

    public function show(int $id)
    {
        $response = $this->api->getRide($id);

        if ($response->failed()) {
            abort(404, 'Ride not found');
        }

        return view('rides.show', ['ride' => $response->json()]);
    }
}
