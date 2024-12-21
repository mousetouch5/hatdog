<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquidation Loom</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.all.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex relative">
    <!-- Background Overlay Image -->

    <!-- Left Section -->
    <div class="w-[900px] bg-white flex flex-col items-center justify-center text-center relative z-10">


        <img src="{{ asset('logo/homeiconpage-removebg-preview.png') }}" alt="Background Overlay"
            class="absolute top-[1%] right-[30%] h-full opacity-30 z-0 object-cover">
        <img src="{{ asset('logo/home1iconpage.png') }}" alt="Logo" class="w-48 mb-16">
        <h1 class="text-5xl font-extrabold mb-4">Liquidation Loom</h1>
        <p class="text-gray-600">Your one-stop solution for efficient barangay financial management and transparency.
        </p>
    </div>


    <!-- Right Section -->
    <div class="flex-1 bg-blue-100 h-auto flex flex-col items-center justify-center text-center relative z-10 ">
        <h3 class="text-2xl font-extrabold mb-6" id="accountRoleHeading">CHOOSE ACCOUNT ROLE <br> TO CREATE</h3>
        <div class="flex space-x-4 mb-6">
            <!-- Official Button with Icon -->

            <!-- Official Icon Above the Button -->
            <div class="flex flex-col items-center mb-4">
            </div>

            <!-- Resident Icon Above the Button -->
            <div class="flex flex-col items-center mb-4">
                <i id="icon1" class="fas fa-user-circle text-3xl mb-2"></i>
                <button id="residentButton"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition mx-auto block"
                    onclick="my_modal_3.showModal()">
                    Resident
                </button>
            </div>

            <x-login.fucking-login />
            <x-register.register-idk2 />

            <x-validation-errors class="mb-4" />




        </div>
        <!-- Links for switching between login and register -->
        <p class="text-gray-600 text-sm" id="loginPrompt">
            Have an Account?
            <a href="javascript:void(0);" id="loginLink" class="text-blue-500 hover:underline">Login Here</a>.
        </p>

        <!-- Alternate link for creating an account -->
        <p class="text-gray-600 text-sm hidden" id="registerPrompt">
            Don't have an account?
            <a href="{{ route('login') }}" id="registerLink" class="text-blue-500 hover:underline">Create an
                Account</a>.
        </p>
    </div>
</body>
<!-- script for offbutton residentbutton  hide -->




<script>
    const accountRoleHeading = document.getElementById('accountRoleHeading');
    const officialButton = document.getElementById('officialButton');
    const residentButton = document.getElementById('residentButton');
    const loginForm = document.getElementById('loginForm');
    const icon = document.getElementById('icon');
    const icon1 = document.getElementById('icon1');
    const loginLink = document.getElementById('loginLink');



    // Add event listener to show the login form when "Login Here" link is clicked
    loginLink.addEventListener('click', function() {
        loginForm.classList.remove('hidden'); // Make the login form visible
        accountRoleHeading.classList.add('hidden'); // Hide the account role heading
        icon.classList.add('hidden'); // Hide the first icon
        icon1.classList.add('hidden'); // Hide the second icon

        // Hide both buttons when the login form is displayed
        officialButton.classList.add('hidden');
        residentButton.classList.add('hidden');
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginPrompt = document.getElementById('loginPrompt');
        const registerPrompt = document.getElementById('registerPrompt');
        const loginLink = document.getElementById('loginLink');
        const registerLink = document.getElementById('registerLink');

        // When "Login Here" is clicked
        loginLink.addEventListener('click', function() {
            // Hide login prompt and show register prompt
            loginPrompt.classList.add('hidden');
            registerPrompt.classList.remove('hidden');
        });

        // When "Create an Account" is clicked
        registerLink.addEventListener('click', function() {
            // Hide register prompt and show login prompt
            registerPrompt.classList.add('hidden');
            loginPrompt.classList.remove('hidden');
        });
    });
</script>
</html>
