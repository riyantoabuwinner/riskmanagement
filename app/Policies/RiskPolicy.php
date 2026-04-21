<?php

namespace App\Policies;

use App\Models\Risk;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RiskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view all risks') || $user->hasPermissionTo('create risks');
    }

    public function view(User $user, Risk $risk): bool
    {
        if ($user->hasPermissionTo('view all risks')) {
            return true;
        }
        if ($user->unit_id && $user->unit_id === $risk->unit_id) {
            return true;
        }
        return $user->id === $risk->created_by;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create risks');
    }

    public function update(User $user, Risk $risk): bool
    {
        if ($risk->status !== 'Draft' && $risk->status !== 'Rejected') {
            return false;
        }
        if ($user->unit_id && $user->unit_id === $risk->unit_id) {
            return true;
        }
        return $user->id === $risk->created_by;
    }

    public function delete(User $user, Risk $risk): bool
    {
        if ($risk->status !== 'Draft') {
            return false;
        }
        if ($user->unit_id && $user->unit_id === $risk->unit_id) {
            return true;
        }
        return $user->id === $risk->created_by;
    }

    public function submit(User $user, Risk $risk): bool
    {
        if ($risk->status !== 'Draft' && $risk->status !== 'Rejected') {
            return false;
        }
        if ($user->unit_id && $user->unit_id === $risk->unit_id) {
            return true;
        }
        return $user->id === $risk->created_by;
    }

    public function review(User $user, Risk $risk): bool
    {
        return $user->hasPermissionTo('review risks') && $risk->status === 'Submitted';
    }

    public function approve(User $user, Risk $risk): bool
    {
        return $user->hasPermissionTo('approve risks') && $risk->status === 'Reviewed';
    }

    public function reject(User $user, Risk $risk): bool
    {
        if ($risk->status === 'Submitted') {
            return $user->hasPermissionTo('review risks');
        }
        if ($risk->status === 'Reviewed') {
            return $user->hasPermissionTo('approve risks');
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Risk $risk): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Risk $risk): bool
    {
        return false;
    }
}
