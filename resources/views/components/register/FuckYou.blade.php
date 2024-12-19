<dialog id="my_modal_10" class="modal">
    <div class="modal-box w-full max-w-4xl">
        <!-- Close button for the modal -->
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="my_modal_10.close()">✕</button>

        <!-- Form for user creation -->
        <form id="signup_form" method="POST" action="{{ route('user.create') }}" class="grid grid-cols-1 gap-6 p-6"
            enctype="multipart/form-data">
            @csrf <!-- CSRF token for security -->
            <!-- Form Fields -->
            <div class="space-y-4">

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label for="position" class="block text-sm font-semibold">Position</label>
                        <select id="position" name="position"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Select Position</option>
                            <option value="Barangay Captain">Barangay Captain</option>
                            <option value="Barangay Secretary">Barangay Secretary</option>
                            <option value="Barangay Treasurer">Barangay Treasurer</option>
                            <option value="Assitant">Assistant</option>
                        </select>
                    </div>
                </div>



                <!-- First Name Field -->
                <div class="form-control">
                    <label for="first_name" class="label">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="input input-bordered w-full"
                        value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Middle Name Field -->
                <div class="form-control">
                    <label for="middle_name" class="label">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" class="input input-bordered w-full"
                        value="{{ old('middle_name') }}">
                    @error('middle_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Last Name Field -->
                <div class="form-control">
                    <label for="last_name" class="label">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="input input-bordered w-full"
                        value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="form-control">
                    <label for="email" class="label">Email Address</label>
                    <input type="email" id="email" name="email" class="input input-bordered w-full"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-control">
                    <label for="password" class="label">Password</label>
                    <input type="password" id="password" name="password" class="input input-bordered w-full" required>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="form-control">
                    <label for="password_confirmation" class="label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="input input-bordered w-full" required>
                    @error('password_confirmation')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Profile Picture Upload -->
                <div class="form-control">
                    <label for="profile_picture" class="label">Profile Picture (optional)</label>
                    <input type="file" id="profile_picture" name="profile_picture"
                        class="input input-bordered w-full">
                    @error('profile_picture')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary w-full">Create User</button>
            </div>
        </form>
    </div>
</dialog>
