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
                            <option value="Assitant">Kagawad</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label for="committee" class="block text-sm font-semibold">Committee</label>
                        <select id="committee" name="committee"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Select Committee</option>
                            <option value="Committee Chair Infrastructure & Finance">Committee Chair Infrastructure &
                                Finance</option>
                            <option value="Committee Chair on Barangay Affairs & Environment">Committee Chair on
                                Barangay Affairs & Environment</option>
                            <option value="Committee Chair on Education">Committee Chair on Education</option>
                            <option value="Committee Chair Peace & Order">Committee Chair Peace & Order</option>
                            <option value="Committee Chair on Laws & Good Governance">Committee Chair on Laws & Good
                                Governance</option>
                            <option value="Committee Chair on Elderly, PWD/VAWC">Committee Chair on Elderly, PWD/VAWC
                            </option>
                            <option value="Committee Chair on Health & Sanitation/ Nutrition">Committee Chair on Health
                                & Sanitation/ Nutrition</option>
                            <option value="Committee Chair on Livelihood">Committee Chair on Livelihood</option>
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
                <button type="button" id="submit_form" class="btn btn-primary w-full">Create User</button>
            </div>
        </form>
    </div>
</dialog>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const submitButton = document.getElementById("submit_form");
        const form = document.getElementById("signup_form");

        submitButton.addEventListener("click", async (event) => {
            event.preventDefault(); // Prevent default behavior

            const formData = new FormData(form); // Gather form data

            try {
                // Send AJAX request
                const response = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                            .value,
                    },
                    body: formData,
                });

                const result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        title: "Success!",
                        text: result.message || "User created successfully!",
                        icon: "success",
                        position: 'top',
                        confirmButtonText: "OK",
                    });
                    form.reset(); // Reset the form
                    my_modal_10.close(); // Close modal
                } else {
                    const errorMessages = Object.values(result.errors || {}).map(
                        (err) => `<p>${err}</p>`
                    ).join("");

                    Swal.fire({
                        title: "Error!",
                        html: errorMessages || result.message || "An error occurred.",
                        icon: "error",
                        position: 'top',
                        confirmButtonText: "OK",
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: "Oops!",
                    text: "An unexpected error occurred. Please try again.",
                    icon: "error",
                    position: 'top',
                    confirmButtonText: "OK",
                });
            }
        });
    });
</script>

<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css">

<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>
