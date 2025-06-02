<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return Inertia::render('Profile/Edit', [
            'user' => $request->user(),
            'info_status' => session('info_status'),
            'password_status' => session('password_status'),
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->user()->isDirty('email')) {
            $user->email_verified_at = null; // Reset email verification if email is changed
        }
        $user->save();

        return redirect()->route('profile.edit')->with('info_status', 'Profile information updated successfully.');;
    }
    public function updatePassword(Request $request)
    {
        $fields = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $request->user()->update([
            'password' => Hash::make($fields['password']),
        ]);

        return redirect()->route('profile.edit')->with('password_status', 'Password updated successfully.');
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();

        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
