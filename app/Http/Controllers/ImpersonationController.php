<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ImpersonationController extends Controller
{
    /**
     * Start impersonating a user.
     * Only Super Admin can impersonate.
     */
    public function impersonate(User $user)
    {
        // Only Super Admin can impersonate
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Hanya Super Admin yang dapat melakukan impersonasi.');
        }

        // Cannot impersonate yourself
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat mengimpersonasi diri sendiri.');
        }

        // Cannot impersonate another Super Admin
        if ($user->hasRole('Super Admin')) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat mengimpersonasi Super Admin lain.');
        }

        // Store the original admin's ID in session
        Session::put('impersonator_id', Auth::id());

        // Login as the target user
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('info', 'Anda sekarang login sebagai ' . $user->name . ' (' . ($user->roles->first()->name ?? 'No Role') . ')');
    }

    /**
     * Stop impersonating and return to original admin account.
     */
    public function stopImpersonating()
    {
        $impersonatorId = Session::get('impersonator_id');

        if (!$impersonatorId) {
            return redirect()->route('dashboard')
                ->with('error', 'Tidak ada sesi impersonasi aktif.');
        }

        $impersonator = User::find($impersonatorId);

        if (!$impersonator) {
            Session::forget('impersonator_id');
            return redirect()->route('dashboard');
        }

        // Restore original admin session
        Session::forget('impersonator_id');
        Auth::login($impersonator);

        return redirect()->route('users.index')
            ->with('success', 'Sesi impersonasi selesai. Anda kembali sebagai ' . $impersonator->name . '.');
    }
}
