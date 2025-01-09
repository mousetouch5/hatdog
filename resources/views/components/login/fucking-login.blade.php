<div id="loginForm" class="hidden mt-4 w-full max-w-lg">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <h3 id="accountRoleHeading" class="text-5xl font-bold mb-6">Login</h3>
    <form id="loginFormAction" action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div class="flex flex-col px-3">
            <label for="email" class="block text-sm font-semibold text-left">Email</label>
            <input type="text" id="email" name="email"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your email" required>
        </div>
        <div class="flex flex-col relative px-3">
            <label for="password" class="block text-sm font-semibold text-left">Password</label>
            <input type="password" id="password" name="password"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your password" required>

            <!-- Show Password Checkbox -->
            <div class=" ml-2 mt-2 flex items-center">
                <input type="checkbox" id="showPassword" class="mr-2" onclick="togglePassword()" />
                <label for="showPassword" class="text-sm text-gray-600">Show Password</label>
            </div>
        </div>

        <div class="px-3">
        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition mt-4 w-full">Login</button>
        </div>
        </form>
</div>




<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginFormAction = document.getElementById('loginFormAction');

        loginFormAction.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Create FormData from the form
            const formData = new FormData(loginFormAction);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Send the login data to the controller (login action)
            fetch("{{ route('login') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json" // Specify that we expect a JSON response
                    },
                    body: formData
                })
                .then(response => response.json()) // Parse response as JSON
                .then(data => {
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Login Successful',
                            text: 'Redirecting to your homepage...',
                            icon: 'success',
                            timer: 3000, // Show for 3 seconds
                            showConfirmButton: false
                        }).then(() => {
                            // Redirect to the homepage after 3 seconds
                            window.location.href = data
                                .redirect_url; // Update this URL as needed
                        });
                    } else {
                        // Show error message if login fails
                        Swal.fire({
                            title: 'Login Failed',
                            text: data.message || 'Something went wrong!',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                })
                .catch(error => {
                    // Handle any network or other errors
                    Swal.fire({
                        title: 'Error',
                        text: error.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        });
    });
</script>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const showPasswordCheckbox = document.getElementById("showPassword");
        passwordInput.type = showPasswordCheckbox.checked ? "text" : "password";
    }
</script>
