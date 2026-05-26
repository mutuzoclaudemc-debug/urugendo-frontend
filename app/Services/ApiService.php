<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiService
{
    private string $base;

    public function __construct()
    {
        $this->base = rtrim(config('services.api.base_url'), '/');
    }

    // ── Auth ──────────────────────────────────────────────────────────────────

    public function register(array $data): Response
    {
        return Http::post("{$this->base}/auth/register", $data);
    }

    public function login(array $data): Response
    {
        return Http::post("{$this->base}/auth/login", $data);
    }

    public function me(): Response
    {
        return $this->authenticated()->get("{$this->base}/auth/me");
    }

    public function updateProfile(array $data): Response
    {
        return $this->authenticated()->put("{$this->base}/auth/me", $data);
    }

    // ── Rides ─────────────────────────────────────────────────────────────────

    public function searchRides(array $params = []): Response
    {
        return Http::get("{$this->base}/rides/search", array_filter($params, fn($v) => $v !== null && $v !== ''));
    }

    public function getRide(int $id): Response
    {
        return Http::get("{$this->base}/rides/{$id}");
    }

    public function createRide(array $data): Response
    {
        return $this->authenticated()->post("{$this->base}/rides/", $data);
    }

    public function myOfferedRides(): Response
    {
        return $this->authenticated()->get("{$this->base}/rides/my/offered");
    }

    public function cancelRide(int $id): Response
    {
        return $this->authenticated()->delete("{$this->base}/rides/{$id}");
    }

    // ── Bookings ──────────────────────────────────────────────────────────────

    public function createBooking(array $data): Response
    {
        return $this->authenticated()->post("{$this->base}/bookings/", $data);
    }

    public function myBookings(): Response
    {
        return $this->authenticated()->get("{$this->base}/bookings/my");
    }

    public function getBooking(int $id): Response
    {
        return $this->authenticated()->get("{$this->base}/bookings/{$id}");
    }

    public function cancelBooking(int $id): Response
    {
        return $this->authenticated()->post("{$this->base}/bookings/{$id}/cancel");
    }

    public function confirmBooking(int $id): Response
    {
        return $this->authenticated()->post("{$this->base}/bookings/{$id}/confirm");
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function authenticated()
    {
        $token = Session::get('api_token');
        return Http::withToken($token);
    }
}
