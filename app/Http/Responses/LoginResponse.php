<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Contracts\Support\Responsable;

class LoginResponse implements LoginResponseContract, Responsable
{
    public function toResponse($request)
    {
        $user = auth()->user();

        // Check if the user is blocked
        if ($user->is_blocked) {
            // Log the user out immediately
            auth()->logout();

            // Check if the request expects JSON
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is blocked. Please contact the administrator.',
                ], 403);
            }

            // Fallback for non-JSON requests
            return redirect()->route('login')->withErrors([
                'email' => 'Your account is blocked. Please contact the administrator.',
            ]);
        }

        // If the user is not blocked, proceed with normal redirection
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect_url' => $this->redirectTo(),
            ]);
        }

        return redirect($this->redirectTo());
    }

    private function redirectTo(): string
    {
        // Determine the redirect URL based on user_type
        $userType = auth()->user()->user_type;

        if ($userType === 'official') {
            return route('Official.OfficialDashboard.index'); // Change this to your official dashboard route
        } elseif ($userType === 'resident') {
            return route('login'); // Change this to your resident dashboard route
        } elseif ($userType === 'admin') {
            return route('superadmin.dashboard'); // Change this to your admin dashboard route
        }

        return route('Resident.dashboard'); // Fallback route for other user types
    }
}
