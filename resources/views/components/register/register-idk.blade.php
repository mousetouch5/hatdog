<dialog id="my_modal_4" class="modal">
    <div class="modal-box w-full max-w-4xl">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="my_modal_4.close()">✕</button>
        <form id="signup_form" method="POST" action="{{ route('register') }}" class="grid grid-cols-1 gap-6 p-6"
            enctype="multipart/form-data">
            @csrf <!-- This directive adds the CSRF token -->
            <input type="hidden" name="usertype" value="official">
            <!-- Form Fields -->
            <div class="space-y-4">
                <!-- Row 1 -->
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-semibold">First Name</label>
                        <input type="text" id="first_name" name="first_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="middle_name" class="block text-sm font-semibold">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-semibold">Last Name</label>
                        <input type="text" id="last_name" name="last_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label for="position" class="block text-sm font-semibold">Position</label>
                        <select id="position" name="position"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Select Position</option>
                            <option value="Barangay Captain">Barangay Captain</option>
                            <option value="Barangay Secretary">Barangay Secretary</option>
                            <option value="Barangay Treasurer">Barangay Treasurer</option>
                            <option value="Assitant">Assitant</option>
                        </select>
                    </div>
                </div>


                <!-- Row 2 -->
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label for="birthdate" class="block text-sm font-semibold">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="brgy_id" class="block text-sm font-semibold">Barangay ID</label>
                        <input type="text" id="brgy_id" name="brgy_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label for="lot_number" class="block text-sm font-semibold">Lot Number</label>
                        <input type="text" id="lot_number" name="lot_number"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="block_number" class="block text-sm font-semibold">Block Number</label>
                        <input type="text" id="block_number" name="block_number"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="purok" class="block text-sm font-semibold">Purok</label>
                        <input type="text" id="purok" name="purok"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label for="brgy_city_zipcode" class="block text-sm font-semibold">Barangay
                        </label>
                        <input type="text" id="brgy_city_zipcode" name="brgy_city_zipcode"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-semibold">City</label>
                        <input type="text" id="city" name="city"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="zipcode" class="block text-sm font-semibold">Zip Code</label>
                        <input type="text" id="zipcode" name="zipcode"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Row 6: Choose File (ID Verification) -->
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label for="profile_picture" class="block text-sm font-semibold">Profile Picture</label>
                        <input type="file" id="profile_picture" name="profile_picture"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('profile_picture')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="id_picture" class="block text-sm font-semibold">ID Picture Must Contain
                            Address</label>
                        <input type="file" id="id_picture" name="id_picture"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('id_picture')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-center mt-4">
                <button type="submit" id="signUpButton"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 w-80">Sign
                    Up</button>
            </div>
        </form>
    </div>
</dialog>
