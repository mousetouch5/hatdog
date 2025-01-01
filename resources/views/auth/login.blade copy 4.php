<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquidation Loom</title>

    <!-- Consolidated CSS imports -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.min.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex">
    <!-- Left Section -->
    <div class="w-[900px] bg-white flex flex-col items-center justify-center text-center relative">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('logo/homeiconpage-removebg-preview.png') }}" alt="Background Pattern"
                class="h-full w-full object-cover opacity-30">
        </div>
        <div class="relative z-10">
            <img src="{{ asset('logo/home1iconpage.png') }}" alt="Liquidation Loom Logo" class="w-48 mb-16">
            <h1 class="text-5xl font-extrabold mb-4">Liquidation Loom</h1>
            <p class="text-gray-600">Your one-stop solution for efficient barangay financial management and
                transparency.</p>
        </div>
    </div>

    <!-- Right Section -->
    <div class="flex-1 bg-blue-100 flex flex-col items-center justify-center relative">
        <!-- Role Selection Section -->
        <div id="roleSelection" class="text-center">
            <h3 class="text-2xl font-extrabold mb-6">CHOOSE ACCOUNT ROLE<br>TO CREATE</h3>
            <div class="flex space-x-8 mb-6">
                <div class="flex flex-col items-center">
                    <i class="fas fa-user-circle text-3xl mb-2" id="residentIcon"></i>
                    <button id="residentButton"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200"
                        onclick="my_modal_3.showModal()">
                        Resident
                    </button>
                </div>
            </div>
        </div>

        <!-- Login Form Section (Initially Hidden) -->
        <div id="loginForm" class="hidden w-full max-w-md px-6">
            <x-login.fucking-login />
        </div>

        <!-- Register Form Section (Initially Hidden) -->
        <div id="registerForm" class="hidden w-full max-w-md px-6">
            <x-register.register-idk2 />
            <x-validation-errors class="mb-4" />
        </div>

        <!-- Authentication Links -->
        <div class="mt-6">
            <p id="loginPrompt" class="text-gray-600 text-sm">
                Have an Account?
                <button id="loginLink" class="text-blue-500 hover:underline">Login Here</button>
            </p>
            <p id="registerPrompt" class="text-gray-600 text-sm hidden">
                Don't have an account?
                <button id="registerLink" class="text-blue-500 hover:underline">Create an Account</button>
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const roleSelection = document.getElementById('roleSelection');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginPrompt = document.getElementById('loginPrompt');
            const registerPrompt = document.getElementById('registerPrompt');
            const loginLink = document.getElementById('loginLink');
            const registerLink = document.getElementById('registerLink');

            // Show Login Form
            function showLogin() {
                roleSelection.classList.add('hidden');
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                loginPrompt.classList.add('hidden');
                registerPrompt.classList.remove('hidden');
            }

            // Show Register Form
            function showRegister() {
                roleSelection.classList.remove('hidden');
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                loginPrompt.classList.remove('hidden');
                registerPrompt.classList.add('hidden');
            }

            // Event Listeners
            loginLink.addEventListener('click', showLogin);
            registerLink.addEventListener('click', showRegister);
        });
    </script>
</body>

</html>
