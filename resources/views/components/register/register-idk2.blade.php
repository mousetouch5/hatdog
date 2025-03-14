<dialog id="my_modal_3" class="modal">
    <div class="modal-box w-full max-w-4xl">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="my_modal_3.close()">✕</button>
        <form id="signup_form" method="POST" class="grid grid-cols-1 gap-6 p-6" enctype="multipart/form-data">
            @csrf <!-- This directive adds the CSRF token -->
            <input type="hidden" name="usertype" value="resident">
            <input type="hidden" name="brgy_city_zipcode" value="idk">
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

                <div class="grid grid-cols-3 gap-6">


                    <div>
                        <label for="brgy_id" class="block text-sm font-semibold">Barangay</label>
                        <input type="text" id="brgy_id" name="brgy_id"
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
            </div>

            <div class="grid grid-cols-3 gap-6">
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

            <dialog id="terms_modal" class="modal">
                <div class="modal-box flex flex-col justify-center items-center text-center">
                    <h3 class="text-lg font-bold mb-4">Terms and Conditions</h3>
                    <p class="py-4 text-justify">
                        <strong>The Terms and Conditions</strong> for our digital liquidation software system govern
                        your use of the Service, requiring you to provide accurate personal information such as your
                        name, email, password, and address. By creating an account, you agree to maintain the security
                        of your login details and use the Service lawfully. We reserve the right to terminate your
                        access for any violations of these Terms. All content is protected by intellectual property
                        laws, and we limit our liability to the fullest extent permitted by law.
                    </p>
                    <div class="modal-action">
                        <!-- Cancel Button -->
                        <button class="btn" type="button" onclick="closeTermsModal()">Close</button>
                    </div>
                </div>
            </dialog>


            <div class="flex items-center mt-4">
                <input type="checkbox" id="agreeTerms" class="mr-2">
                <label for="agreeTerms" class="text-sm">I agree to the <a href="#" onclick="openTermsModal()"
                        class="text-blue-600 underline">Terms and Conditions</a>.</label>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-center mt-4">
                <button type="submit" id="signUpButton" disabled
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 w-80 disabled:opacity-50 disabled:cursor-not-allowed">
                    Sign Up
                </button>
            </div>
        </form>
    </div>
</dialog>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const agreeTermsCheckbox = document.getElementById('agreeTerms');
        const signUpButton = document.getElementById('signUpButton');
        let hasOpenedModal = false; // Track if the modal has been opened

        // Listen for changes on the checkbox
        agreeTermsCheckbox.addEventListener('change', function() {
            if (this.checked && !hasOpenedModal) {
                // Open the modal if it's the first time checking
                openTermsModal();
                hasOpenedModal = true; // Mark that the modal has been opened
                this.checked = false; // Uncheck the box until terms are accepted
            } else {
                // Enable or disable the button based on checkbox state
                signUpButton.disabled = !this.checked;
            }
        });
    });

    // Open the Terms Modal
    function openTermsModal() {
        document.getElementById('terms_modal').showModal();
    }

    // Close the Terms Modal
    function closeTermsModal() {
        document.getElementById('terms_modal').close();
    }

    // Function when user accepts the terms
    function acceptTerms() {
        Swal.fire({
            icon: 'success',
            title: 'You have accepted the terms and conditions.',
            position: 'top',
            toast: true,
            target: '#my_modal_3',
        }).then(() => {
            // Check the terms checkbox and enable the button
            const agreeTermsCheckbox = document.getElementById('agreeTerms');
            agreeTermsCheckbox.checked = true;
            document.getElementById('signUpButton').disabled = false;
            closeTermsModal();
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#signup_form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('register') }}", // Fortify's registration route
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        position: 'top',
                        toast: true,
                        target: '#my_modal_3',
                    }).then(() => {
                        window.location.href = response
                            .redirect; // Redirect to the provided URL
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '<ul>';
                        $.each(errors, function(key, value) {
                            errorMessages +=
                                `<li>${value[0]}</li>`; // Display each error in a list
                        });
                        errorMessages += '</ul>';

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Errors',
                            html: errorMessages, // Display errors as HTML
                            position: 'top',
                            target: '#my_modal_3',
                        });
                    } else {
                        // Other errors
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: xhr.responseJSON?.message ||
                                'Something went wrong. Please try again later.',
                            position: 'top',
                            target: '#my_modal_3',
                        });
                    }
                }
            });
        });
    });
</script>
