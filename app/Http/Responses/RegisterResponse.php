<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function toResponse($request)
    {
        // Get the authenticated user
        $user = $this->guard->user();

        // Check if the request is an AJAX request
        if ($request->expectsJson()) {
            if ($user->user_type === 'official') {
                // Log out the user immediately
                $this->guard->logout();

                return response()->json([
                    'message' => 'Registration successful! Please wait for admin approval.',
                    'redirect' => route('login'), // Redirect URL for login page
                ], 200);
            }

            if ($user->user_type === 'resident') {
                return response()->json([
                    'message' => 'Welcome! You are now logged in.',
                    'redirect' => route('dashboard'), // Redirect URL for dashboard
                ], 200);
            }

            // Default fallback for other user types
            return response()->json([
                'message' => 'Registration successful!',
                'redirect' => url('/'), // Redirect URL for fallback
            ], 200);
        }

        // Handle non-AJAX requests (default behavior)
        if ($user->user_type === 'official') {
            $this->guard->logout();
            return redirect()->route('login')->with('status', 'Registration successful! Please wait for admin approval.');
        }

        if ($user->user_type === 'resident') {
            return redirect()->route('dashboard')->with('status', 'Welcome! You are now logged in.');
        }

        return redirect('/');
    }
}
