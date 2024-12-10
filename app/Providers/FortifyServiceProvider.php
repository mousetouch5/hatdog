<?php

namespace App\Providers;

use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Http\Responses\LoginResponse; // Ensure this is correct
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Models\User;
use App\Http\Responses\RegisterResponse; // Import the custom RegisterResponse

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    $this->app->singleton(
    \Laravel\Fortify\Contracts\RegisterResponse::class,
    \App\Http\Responses\RegisterResponse::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom authentication logic
        Fortify::authenticateUsing(function ($request) {
            // Validate user credentials
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return null; // No user found
            }

            // Check if the user is approved
            if (!$user->is_approved) {
                return null; // Deny login if not approved
            }

            // Validate the password
            if (Hash::check($request->password, $user->password)) {
                return $user; // Login successful
            }

            return null; // Deny login if credentials are invalid
        });

        // Use custom CreateNewUser action for registration
        Fortify::createUsersUsing(CreateNewUser::class);

        // Other Fortify actions
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Rate limiting for login and two-factor authentication
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // View for registration (ensure this is the correct view for registration)
        Fortify::registerView(function () {
            return view('auth.register'); // Make sure this is the correct registration view
        });
    }
}
