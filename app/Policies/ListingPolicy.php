<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Listing $listing): bool
    {
        // Admin can view all listings
        if ($user && $user->role === 'admin') {
            return true;
        }

        // Listing owner can view their own listings
        if ($user && $listing->user_id === $user->id) {
            return true;
        }

        // Others can only view approved listings from non-suspended users
        return $listing->is_approved && $listing->user->role !== 'suspended';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role !== 'suspended';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id && $user->role !== 'suspended';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Listing $listing): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Listing $listing): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Listing $listing): bool
    {
        //
    }
    /**
     * Determine whether the user can approve or disapprove the listing.
     */
    public function approve(User $user, Listing $listing): bool
    {
        // Only admin can approve or disapprove listings
        return $user->isAdmin();
    }
}
