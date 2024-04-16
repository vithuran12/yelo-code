<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool//whether or not user can see any table over category
    {
        return false;
        //return $user->isAdmin() ;
        //return $user->isAdmin() || $user->isEditor();//side bar la category resource show aakathu

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category): bool
    {
        return $user->isAdmin();
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
       // return true;
        return $user->isAdmin();

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->isAdmin();

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restoreAny(User $user): bool
    {
        return $user->isAdmin();

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->isAdmin();

    }

    
}
