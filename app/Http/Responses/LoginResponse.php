<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Contracts\Support\Responsable;

class LoginResponse implements LoginResponseContract, Responsable
{

    public function toResponse($request)
    {
        // Check if the request expects a JSON response
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect_url' => $this->redirectTo(), // Use redirectTo method for dynamic URL
            ]);
        }

        // Fallback to redirect in non-JSON requests
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
        }
        elseif ($userType === 'admin') {
            return route('superadmin.dashboard'); // Change this to your resident dashboard route
        }

        return route('Resident.dashboard'); // Fallback route for other user types
    }


}