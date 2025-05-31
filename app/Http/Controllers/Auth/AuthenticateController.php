<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthenticateController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render(component: 'Auth/Login');
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            // Redirect to the intended page or home
            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
