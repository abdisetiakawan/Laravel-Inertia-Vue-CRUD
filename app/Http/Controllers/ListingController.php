<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotSuspended;
use App\Models\Listing;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ListingController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware(
                ['auth', 'verified', NotSuspended::class],
                except: ['index', 'show']
            ),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listings = Listing::whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })
            ->with('user')
            ->where('is_approved', true)
            ->filter(request(['search', 'user_id', 'tags']))
            ->latest()
            ->paginate(6)
            ->withQueryString();
        return Inertia::render('Home', [
            'listings' => $listings,
            'searchTerm' => $request->search,
            'status' => session('status'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Listing::class);
        return Inertia::render('Listings/Create', ['status' => session('status')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Listing::class);
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'email' => 'nullable|email',
            'tags' => 'nullable|string',
            'link' => 'nullable|url',
            'image' => 'nullable|image|max:3072', // 3MB max
        ]);

        if ($request->hasFile('image')) {
            $fields['image'] = Storage::disk('public')->putFileAs(
                'images/listings',
                $request->file('image'),
                time() . '-' . $request->file('image')->getClientOriginalName()
            );
        }

        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',',  $request->tags)))));

        $request->user()->listings()->create($fields);
        return redirect()->route('listings.create')->with('status', 'Listing created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);
        return Inertia::render(
            'Listings/Show',
            [
                'listing' => $listing,
                'user' => $listing->user->only(['id', 'name']),
                'status' => session('status'),
                'canUpdate' => Auth::user() ? Auth::user()->can('update', $listing) : false,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize('update', $listing);
        return Inertia::render('Listings/Edit', [
            'listing' => $listing,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        Gate::authorize('update', $listing);
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'email' => 'nullable|email',
            'tags' => 'nullable|string',
            'link' => 'nullable|url',
            'image' => 'nullable|image|max:3072', // 3MB max
        ]);

        if ($request->hasFile('image')) {
            if ($listing->image) {
                Storage::disk('public')->delete($listing->image);
            }
            $fields['image'] = Storage::disk('public')->putFileAs(
                'images/listings',
                $request->file('image'),
                time() . '-' . $request->file('image')->getClientOriginalName()
            );
        } else {
            $fields['image'] = $listing->image;
        }

        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',',  $request->tags)))));

        $listing->update($fields);
        return redirect()->route('listings.show', $listing->id)->with('status', 'Listing updated successfully!');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize('update', $listing);
        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }
        $listing->delete();
        return redirect()->route('home')->with('status', 'Listing deleted successfully!');
    }
}
