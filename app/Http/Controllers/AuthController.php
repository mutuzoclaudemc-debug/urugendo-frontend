<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct(private ApiService $api) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string',
            'password' => 'required|string',
        ]);

        $response = $this->api->login($request->only('phone', 'password'));

        if ($response->failed()) {
            return back()->withErrors(['phone' => $response->json('detail') ?? 'Login failed.'])->withInput();
        }

        $data = $response->json();
        Session::put('api_token', $data['access_token']);
        Session::put('user', $data['user']);

        return redirect()->intended('/dashboard');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|min:2',
            'phone'     => 'required|string',
            'email'     => 'nullable|email',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        $response = $this->api->register($request->only('full_name', 'phone', 'email', 'password'));

        if ($response->failed()) {
            $detail = $response->json('detail') ?? 'Registration failed.';
            return back()->withErrors(['phone' => $detail])->withInput();
        }

        $data = $response->json();
        Session::put('api_token', $data['access_token']);
        Session::put('user', $data['user']);

        return redirect('/dashboard');
    }

    public function logout()
    {
        Session::forget(['api_token', 'user']);
        return redirect('/');
    }
}
