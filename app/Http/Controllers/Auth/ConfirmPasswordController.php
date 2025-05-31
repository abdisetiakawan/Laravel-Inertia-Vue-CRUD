<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ConfirmPasswordController extends Controller
{
    public function showConfirmPasswordForm()
    {
        return Inertia::render('Auth/ConfirmPassword');
    }
    public function confirmPassword(Request $request)
    {
        if (!Hash::check($request->input('password'), $request->user()->password)) {
            return back()->withErrors(['password' => __('The provided password does not match your current password.')]);
        }
        $request->session()->passwordConfirmed();
        return redirect()->intended();
    }
}
