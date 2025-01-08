<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('user_type', ['official', 'resident', 'admin'])->default('resident'); // User type column
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('id_picture_path', 2048)->nullable(); 
            $table->timestamps();

            // Additional columns
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable(); // Middle name can be optional
            $table->string('last_name')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('brgy_id')->default('1');
            $table->string('lot_number')->nullable();
            $table->string('block_number')->nullable();
            $table->string('purok')->nullable();
            $table->string('city')->default('Bacolod');
            $table->string('brgy_city_zipcode')->default('1');
            $table->string('position')->nullable();
            $table->string('comittee')->nullable();
            $table->boolean('is_approved')->default(false); // Approved by superadmin or not
        });

    DB::table('users')->insert([
    [
        'name' => 'Admin Official',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'user_type' => 'official',
        'first_name' => 'Admin',
        'middle_name' => null,
        'last_name' => 'Official',
        'birthdate' => '1980-01-01',
        'brgy_id' => '1',
        'lot_number' => '123',
        'block_number' => 'A',
        'purok' => '1',
        'city' => 'Admin City',
        'brgy_city_zipcode' => '1000',
        'created_at' => now(),
        'updated_at' => now(),
        'position' => null,
        'is_approved' => true,
        'current_team_id' => null, // Ensure this is filled if needed
        'profile_photo_path' => null, // Set to null if not available
    ],
    [
        'name' => 'Super Admin',
        'email' => 'admin@admin.com',
        'password' => Hash::make('password'),
        'user_type' => 'admin',
        'first_name' => 'SA',
        'middle_name' => null,
        'last_name' => 'Admin',
        'birthdate' => '1980-01-01',
        'brgy_id' => '1',
        'lot_number' => '123',
        'block_number' => 'A',
        'purok' => '1',
        'city' => 'Admin City',
        'brgy_city_zipcode' => '1000',
        'created_at' => now(),
        'updated_at' => now(),
        'is_approved' => true,
        'position' => null,
        'current_team_id' => null, // Ensure this is filled if needed
        'profile_photo_path' => null, // Set to null if not available
    ],
    [
        'name' => 'Resident John',
        'email' => 'resident.john@example.com',
        'password' => Hash::make('password'),
        'user_type' => 'resident',
        'first_name' => 'John',
        'middle_name' => 'M',
        'last_name' => 'Doe',
        'birthdate' => '1990-06-15',
        'brgy_id' => '2',
        'lot_number' => '456',
        'block_number' => 'B',
        'purok' => '2',
        'city' => 'Resident City',
        'brgy_city_zipcode' => '2000',
        'created_at' => now(),
        'updated_at' => now(),
        'position' => null,
        'is_approved' => true,
        'current_team_id' => null, // Ensure this is filled if needed
        'profile_photo_path' => null, // Set to null if not available
    ],
    [
        'name' => 'Resident Jane',
        'email' => 'resident.jane@example.com',
        'password' => Hash::make('password'),
        'user_type' => 'resident',
        'first_name' => 'Jane',
        'middle_name' => 'A',
        'last_name' => 'Smith',
        'birthdate' => '1992-03-10',
        'brgy_id' => '3',
        'lot_number' => '789',
        'block_number' => 'C',
        'purok' => '3',
        'city' => 'Resident Town',
        'brgy_city_zipcode' => '3000',
        'created_at' => now(),
        'updated_at' => now(),
        'position' => null,
        'is_approved' => false,
        'current_team_id' => null, // Ensure this is filled if needed
        'profile_photo_path' => null, // Set to null if not available
    ]
]);


        // Create the password_reset_tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Create the sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
