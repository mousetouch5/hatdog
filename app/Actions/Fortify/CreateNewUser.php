<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Actions\Fortify\PasswordValidationRules;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Log the input data to track the registration process
        Log::info('Creating a new user with input: ', $input);

        // Validation rules
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'brgy_id' => ['required', 'string', 'max:255'],
            'lot_number' => ['nullable', 'string', 'max:255'],
            'block_number' => ['nullable', 'string', 'max:255'],
            'purok' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'brgy_city_zipcode' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'usertype' => ['required', 'string', 'in:official,resident'],
            'profile_picture' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'password' => $this->passwordRules(),
        ];

        // Add ID picture and position validation for officials
        if ($input['usertype'] === 'official') {
            $rules['id_picture'] = ['required', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048'];
            $rules['position'] = ['required', 'string', 'max:255'];
        } else {
            $rules['position'] = ['nullable', 'string', 'max:255']; // Optional for residents
        }

        // Validate user input
        Validator::make($input, $rules)->validate();

        // File upload handling
        $profilePicturePath = $this->storeFileIfExists($input, 'profile_picture', 'resources/profile_pictures');
        $idPicturePath = $this->storeFileIfExists($input, 'id_picture', 'resources/id_pictures');

        // Determine approval status
        $isApproved = ($input['usertype'] === 'resident'); // Residents are automatically approved

        // Create the new user
        $user = User::create([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'] ?? null,
            'last_name' => $input['last_name'],
            'birthdate' => $input['birthdate'],
            'brgy_id' => $input['brgy_id'],
            'lot_number' => $input['lot_number'] ?? null,
            'block_number' => $input['block_number'] ?? null,
            'purok' => $input['purok'] ?? null,
            'city' => $input['city'],
            'brgy_city_zipcode' => $input['brgy_city_zipcode'],
            'name' => trim($input['first_name'] . " " . ($input['middle_name'] ?? '') . " " . $input['last_name']),
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'user_type' => $input['usertype'],
            'profile_photo_path' => $profilePicturePath,
            'id_picture_path' => $idPicturePath,
            'position' => $input['position'] ?? null, // Position only for officials
            'is_approved' => $isApproved,
        ]);

        Log::info('User created successfully with ID: ', [$user->id]);

        return $user;
    }

    /**
     * Store file if it exists in the input.
     */
    private function storeFileIfExists(array $input, string $key, string $directory): ?string
    {
        if (isset($input[$key])) {
            $file = $input[$key];
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path($directory);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);

            return "$directory/$fileName";
        }
        return null;
    }
}
