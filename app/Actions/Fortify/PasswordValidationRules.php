<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(): array
    {
        return [
            'required', // Password is required
            'string', // It must be a string
            Password::min(12) // Minimum length of 12 characters
                ->mixedCase() // Must include both uppercase and lowercase characters
                ->numbers() // Must include numbers
                ->symbols(), // Must include special characters (e.g., !, @, #, $, etc.)
     // Checks if the password has been compromised in known data breaches
            'confirmed', // Password confirmation must match
        ];
    }
}
