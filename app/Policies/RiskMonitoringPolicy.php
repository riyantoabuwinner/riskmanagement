<?php

namespace App\Policies;

use App\Models\RiskMonitoring;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RiskMonitoringPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('monitor risks') || $user->hasPermissionTo('create risks');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RiskMonitoring $riskMonitoring): bool
    {
        if ($user->hasPermissionTo('monitor risks')) {
            return true;
        }
        return $riskMonitoring->risk && $user->id === $riskMonitoring->risk->created_by;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('monitor risks') || $user->hasPermissionTo('create risks');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RiskMonitoring $riskMonitoring): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RiskMonitoring $riskMonitoring): bool
    {
        return $user->hasRole('Super Admin') || $user->hasRole('Admin') || $user->hasRole('Risk Manager');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RiskMonitoring $riskMonitoring): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RiskMonitoring $riskMonitoring): bool
    {
        return false;
    }
}
