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
        // Check the user type after registration
        $user = $this->guard->user();

        if ($user->user_type === 'official') {
            // Log out the user immediately
            $this->guard->logout();

            // Redirect to login page with a message
            return redirect()->route('login')->with('status', 'Registration successful! Please wait for admin approval.');
        }

        if ($user->user_type === 'resident') {
            // Automatically log in the user and redirect to dashboard
            return redirect()->route('dashboard')->with('status', 'Welcome! You are now logged in.');
        }

        // Default behavior (fallback)
        return redirect('/');
    }
}