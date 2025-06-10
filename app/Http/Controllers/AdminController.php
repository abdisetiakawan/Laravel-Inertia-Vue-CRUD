<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        $user = User::with('listings')
            ->filter(request(['search', 'user_role']))
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Admin/AdminDashboard', [
            'users' => $user,
            'status' => session('status'),
        ]);
    }

    public function show(User $user)
    {
        $user_listings = $user->listings()->paginate(10); // Tambahkan paginate() untuk mengeksekusi query
        return Inertia::render('Admin/UserPage', [
            'user' => $user,
            'listings' => $user_listings,
        ]);
    }

    public function role(Request $request, User $user)
    {
        $request->validate(['role' => 'string|required']);

        $user->update(['role' => $request->role]);

        return redirect()
            ->route('admin.index')
            ->with('status', "User role changed to {$request->role} successfully.");
    }
}
