<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return Inertia::render('Profile/Edit', [
            'user' => $request->user(),
            'status' => session('status'),
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

        return redirect()->route('profile.edit');
    }
}
