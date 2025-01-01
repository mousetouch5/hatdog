<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquidation Loom</title>

    <!-- CSS Dependencies -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex">
    <!-- Left Section -->
    <div class="w-[900px] bg-white flex flex-col items-center justify-center text-center relative">
        <img src="/logo/homeiconpage-removebg-preview.png" alt="Background Overlay"
            class="absolute top-[1%] right-[30%] h-full opacity-30 object-cover">
        <img src="/logo/home1iconpage.png" alt="Logo" class="w-48 mb-16 relative z-10">
        <h1 class="text-5xl font-extrabold mb-4 relative z-10">Liquidation Loom</h1>
        <p class="text-gray-600 relative z-10">Your one-stop solution for efficient barangay financial management and
            transparency.</p>
    </div>

    <!-- Right Section -->
    <div class="flex-1 bg-blue-100 flex flex-col items-center justify-center text-center relative">
        <!-- Account Role Selection -->
        <div id="roleSelection" class="w-full">
            <h3 class="text-2xl font-extrabold mb-6">CHOOSE ACCOUNT ROLE<br>TO CREATE</h3>
            <div class="flex justify-center space-x-8 mb-6">
                <div class="flex flex-col items-center">
                    <i class="fas fa-user-circle text-3xl mb-2"></i>
                    <button id="residentButton"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"
                        onclick="my_modal_3.showModal()">
                        Resident
                    </button>
                </div>
            </div>
        </div>

        <!-- Login Form (Hidden by default)
        <div id="loginForm" class="hidden w-full max-w-md px-6">
            
        </div>-->
        <x-login.fucking-login />
        <x-register.register-idk2 />

        <x-validation-errors class="mb-4" />
        <!-- Toggle Links -->
        <div class="mt-6">
            <p id="loginPrompt" class="text-gray-600 text-sm">
                Have an Account?
                <a href="#" id="loginLink" class="text-blue-500 hover:underline">Login Here</a>
            </p>
            <p id="registerPrompt" class="text-gray-600 text-sm hidden">
                Don't have an account?
                <a href="#" id="registerLink" class="text-blue-500 hover:underline">Create an Account</a>
            </p>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.all.min.js"></script>

    <script>
        // Show/Hide Login Form
        document.getElementById('loginLink').addEventListener('click', function() {
            document.getElementById('roleSelection').classList.add('hidden');
            document.getElementById('loginForm').classList.remove('hidden');
            document.getElementById('loginPrompt').classList.add('hidden');
            document.getElementById('registerPrompt').classList.remove('hidden');
        });

        // Show/Hide Registration Options
        document.getElementById('registerLink').addEventListener('click', function() {
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('roleSelection').classList.remove('hidden');
            document.getElementById('registerPrompt').classList.add('hidden');
            document.getElementById('loginPrompt').classList.remove('hidden');
        });

        // Modal function
    </script>
</body>

</html>
