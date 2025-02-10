<x-app-layout>
    <div class="flex h-full min-h-screen">
        <!-- Sidebar -->
        <x-sidebar class="custom-sidebar-class" />

        <!-- Main Content -->
        <div class="bg-gray-100 flex flex-col items-center justify-center w-full">
            <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 mx-4">
                <!-- Title -->
                <h1 class="text-2xl font-bold mb-8 text-center">Budget Planning</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form id="addTransactionForm" action="{{ route('budget.store2') }}" method="POST">
                    @csrf

                    <!-- Year and Yearly Budget Section -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <!-- Year Input -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year:</label>
                            <select id="year" name="year"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                <option value="" disabled selected>Select Year</option>
                                <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                            </select>
                        </div>

                        <!-- Yearly Budget Input -->
                        <div>
                            <label for="yearly_budget" class="block text-sm font-medium text-gray-700 mb-1">Year
                                Budget:</label>
                            <input type="number" id="yearly_budget" name="yearly_budget"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter Budget" required step="0.01" min="0"
                                value="{{ $totalBudget }}" readonly />

                        </div>
                    </div>



                    <!-- Allocated Budget Section -->
                    <h3 class="text-lg font-semibold mb-6">Allocated Budget</h3>
                    <div id="committee-container" class="space-y-4">
                        @php
                            $committees = [
                                'Committee Chair Infrastructure Finance',
                                'Committee Chair on Barangay Affairs Environment',
                                'Committee Chair on Education',
                                'Committee Chair Peace Order',
                                'Committee Chair on Laws Good Governance',
                                'Committee Chair on Elderly PWD VAWC',
                                'Committee Chair on Health Sanitation Nutrition',
                                'Committee Chair on Livelihood',
                            ];
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($committees as $committee)
                                <div class="flex items-center justify-between bg-gray-100 p-3 rounded-md">
                                    <span class="text-gray-700">{{ $committee }}</span>
                                    <div class="flex gap-2">
                                        <input type="number"
                                            name="{{ Str::snake(str_replace([' ', ',', '&', '/'], '_', $committee)) }}_percentage"
                                            class="percentage-input w-20 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="%" min="0" max="100" />
                                        <input type="text"
                                            name="{{ Str::snake(str_replace([' ', ',', '&', '/'], '_', $committee)) }}"
                                            class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="₱0.00" readonly />
                                    </div>
                                </div>
                            @endforeach
                        </div>





                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const totalBudgetInput = document.getElementById("yearly_budget");

                                document.querySelectorAll(".percentage-input").forEach(input => {
                                    input.addEventListener("input", function() {
                                        const percentage = parseFloat(this.value) || 0;
                                        const budgetInput = this.closest(".flex").querySelector(".committee-input");

                                        // Get the numeric value from the yearly budget input
                                        const totalBudget = parseFloat(totalBudgetInput.value.replace(/[^0-9.]/g,
                                            "")) || 0;

                                        //if (percentage >= 0 && percentage <= 100) {
                                        const budgetValue = (percentage / 100) * totalBudget;
                                        budgetInput.value =
                                            `₱${budgetValue.toLocaleString("en-US", { minimumFractionDigits: 2 })}`;
                                        updatePercentage(budgetInput, totalBudget);

                                    });
                                });
                            });
                        </script>





                        <!-- Calendar of Activities -->
                        <div class="mt-5">
                            <button type="button"
                                onclick="window.location.href='{{ route('Official.CalendarActivities.index') }}'"
                                class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500">
                                Calendar of Activities
                            </button>
                        </div>

                        <div class="mt-8 text-right">
                            <h4 class="text-lg font-semibold mb-4 ml-auto">
                                Total Percentage: <span id="percentage-warning" class="font-bold"></span>
                            </h4>
                        </div>





                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                function updateTotalPercentage() {
                                    let total = 0;
                                    document.querySelectorAll(".percentage-input").forEach(input => {
                                        total += parseFloat(input.value) || 0;
                                    });

                                    let messageBox = document.getElementById("percentage-warning");
                                    let remaining = 100 - total;

                                    if (remaining > 0) {
                                        messageBox.textContent =
                                            `${total.toFixed(2)}% | Remainiaaaaaaaaaaaaaaaaaaaaaang: ${remaining.toFixed(2)}%`;
                                        messageBox.style.color = "orange";
                                    } else if (remaining < 0) {
                                        let exceeded = Math.abs(remaining);
                                        messageBox.textContent =
                                            `⚠ ${total.toFixed(2)}% | Exceeded by: ${exceeded.toFixed(2)}% (Please stop!)`;
                                        messageBox.style.color = "red";
                                    } else {
                                        messageBox.textContent = `✅ ${total.toFixed(2)}% (Perfect!)`;
                                        messageBox.style.color = "green";
                                    }
                                }

                                document.querySelectorAll(".percentage-input").forEach(input => {
                                    input.addEventListener("input", updateTotalPercentage);
                                });

                                updateTotalPercentage(); // Initialize on page load
                            });
                        </script>




                        <!-- Save Button -->
                        <div class="mt-8 text-right">
                            <button type="button"
                                class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500"
                                onclick="
        if (validateBudgetForm()) { 
            document.getElementById('my_modal_2').showModal(); 
        }
    ">
                                Save
                            </button>

                        </div>

                        <!-- Modal -->
                        <dialog id="my_modal_2" class="modal">
                            <div class="modal-box">
                                <h3 class="text-lg font-bold">Confirmation</h3>
                                <p class="py-4">Please review the following information carefully. Do you want to save
                                    these changes?</p>
                                <div class="modal-action">
                                    <!-- Cancel Button -->
                                    <button class="btn" type="button"
                                        onclick="document.getElementById('my_modal_2').close()">No</button>
                                    <!-- Confirm Button -->
                                    <!-- Yes Button -->
                                    <button type="button" class="btn btn-primary bg-gray-700"
                                        onclick="
        sanitizeInputs(); 
        document.getElementById('my_modal_2').close(); 
        document.getElementById('addTransactionForm').submit();
    ">
                                        Yes
                                    </button>


                                </div>
                            </div>
                        </dialog>
                </form>


                <!-- External Ja
                    vaScript -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const yearlyBudgetInput = document.getElementById('yearly_budget');
                        const committeeInputs = document.querySelectorAll('.committee-input');

                        // Automatically distribute budget and update percentages on page load
                        if (yearlyBudgetInput && committeeInputs.length > 0) {
                            distributeBudgetAutomatically();
                        }

                        // Function to distribute budget equally among committees
                        document.getElementById('yearly_budget').addEventListener('input', function() {
                            updateCommitteeBudgets();
                        });

                        document.querySelectorAll('.percentage-input').forEach(input => {
                            input.addEventListener('input', function() {
                                updateCommitteeBudgets();
                            });
                        });

                        function updateCommitteeBudgets() {
                            const yearlyBudget = parseFloat(document.getElementById('yearly_budget').value.replace(/[₱,]/g,
                                '')) || 0;
                            const committeeInputs = document.querySelectorAll('.committee-input');
                            let totalPercentage = 0;

                            // Calculate total percentage to ensure it doesn't exceed 100
                            document.querySelectorAll('.percentage-input').forEach(input => {
                                totalPercentage += parseFloat(input.value) || 0;
                            });

                            if (totalPercentage > 100) {
                                alert('Total percentage cannot exceed 100%');
                                return;
                            }

                            committeeInputs.forEach(input => {
                                const percentageInput = input.previousElementSibling;
                                const percentage = parseFloat(percentageInput.value) || 0;
                                const allocatedAmount = (yearlyBudget * percentage) / 100;

                                input.value = allocatedAmount ?
                                    `₱${allocatedAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}` : '₱0.00';
                            });
                        }

                        // Function to update percentage dynamically
                        function updatePercentage(input, yearlyBudget) {
                            const allocatedAmount = parseFloat(input.value.replace(/[₱,]/g, '')) || 0;
                            const percentage = yearlyBudget ? ((allocatedAmount / yearlyBudget) * 100).toFixed(2) : 0;

                            // Find or create the percentage display element
                            let percentageDisplay = input.nextElementSibling;
                            if (!percentageDisplay || !percentageDisplay.classList.contains('percentage-display')) {
                                percentageDisplay = document.createElement('span');
                                percentageDisplay.classList.add('percentage-display', 'ml-2', 'text-sm');
                                input.parentNode.appendChild(percentageDisplay);
                            }

                            // Set the percentage text
                            percentageDisplay.textContent = `(${percentage}%)`;

                            // Change the color to red if the percentage exceeds 100%
                            if (percentage > 100) {
                                percentageDisplay.classList.add('text-red-500'); // Add red color class
                            } else {
                                percentageDisplay.classList.remove('text-red-500'); // Remove red color class if <= 100%
                            }
                        }

                        // Validate form submission
                        window.validateBudgetForm = function() {
                            const yearlyBudget = parseFloat(yearlyBudgetInput.value.replace(/[₱,]/g, '')) || 0;
                            let totalAllocated = 0;

                            committeeInputs.forEach(input => {
                                const value = parseFloat(input.value.replace(/[₱,]/g, '')) || 0;
                                totalAllocated += value;
                            });

                            if (totalAllocated !== yearlyBudget) {
                                alert(
                                    `The total allocated budget (${totalAllocated.toFixed(2)}) does not match the yearly budget (${yearlyBudget.toFixed(2)}). Please adjust the values.`
                                );
                                return false; // Prevent form submission
                            }
                            return true; // Allow form submission
                        };

                        // Sanitize inputs before form submission
                        window.sanitizeInputs = function() {
                            yearlyBudgetInput.value = yearlyBudgetInput.value.replace(/[₱,]/g, '');
                            committeeInputs.forEach(input => {
                                input.value = input.value.replace(/[₱,]/g, '');
                            });
                        };

                        // Add event listeners for real-time updates
                        committeeInputs.forEach(input => {
                            input.addEventListener('input', function() {
                                const yearlyBudget = parseFloat(yearlyBudgetInput.value.replace(/[₱,]/g, '')) ||
                                    0;
                                updatePercentage(this, yearlyBudget);
                            });
                        });
                    });






                    function validateBudgetForm() {
                        const form = document.getElementById('addTransactionForm');

                        if (!form) {
                            console.error("Form with id 'addTransactionForm' not found");
                            return false; // Return false to indicate validation failure
                        }

                        // Retrieve the yearly budget value
                        const yearlyBudgetInput = document.getElementById('yearly_budget');
                        const yearlyBudget = parseFloat(yearlyBudgetInput.value.replace(/[₱,]/g, '')) || 0;

                        // Retrieve all committee inputs and calculate total allocated budget
                        const committeeInputs = document.querySelectorAll('.committee-input');
                        let totalAllocated = 0;

                        // Log all committee input values
                        console.log("Yearly Budget:", yearlyBudget);
                        console.log("Committee Allocations:");

                        committeeInputs.forEach(input => {
                            const value = parseFloat(input.value.replace(/[₱,]/g, '')) || 0;
                            totalAllocated += value;
                            console.log(`${input.name}: ${value}`);
                        });

                        // Check if the total allocated matches the yearly budget
                        if (totalAllocated !== yearlyBudget) {
                            alert(
                                `The total allocated budget (${totalAllocated.toFixed(2)}) does not match the yearly budget (${yearlyBudget.toFixed(2)}). Please adjust the values.`
                            );
                            console.log("Validation failed: Form submission prevented due to mismatched budgets");
                            return false; // Return false to indicate validation failure
                        }

                        console.log("Validation passed: Form submission allowed");
                        return true; // Return true to indicate validation success
                    }


                    // Function to remove formatting before form submission
                    function sanitizeInputs() {
                        const committeeInputs = document.querySelectorAll('.committee-input');
                        const yearlyBudgetInput = document.getElementById('yearly_budget');

                        // Remove formatting from yearly budget
                        yearlyBudgetInput.value = yearlyBudgetInput.value.replace(/[₱,]/g, '');

                        // Remove formatting from committee inputs
                        committeeInputs.forEach(input => {
                            input.value = input.value.replace(/[₱,]/g, '');
                        });

                        console.log("Sanitized inputs before submission:");
                        console.log("Yearly Budget:", yearlyBudgetInput.value);
                        committeeInputs.forEach(input => {
                            console.log(`${input.name}: ${input.value}`);
                        });
                    }
                </script>
</x-app-layout>
