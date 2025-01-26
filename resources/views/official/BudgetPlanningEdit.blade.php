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
                <form id="addTransactionForm" action="{{ route('budget.store') }}" method="POST">
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
                                @for ($i = now()->year; $i >= 2000; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Yearly Budget Input -->
                        <div>
                            <label for="yearly_budget" class="block text-sm font-medium text-gray-700 mb-1">Year
                                Budget:</label>
                            <input type="number" id="yearly_budget" name="yearly_budget"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter Budget" required step="0.01" min="0" />

                        </div>
                    </div>

                    <!-- Allocated Budget Section -->
                    <h3 class="text-lg font-semibold mb-6">Allocated Budget</h3>
                    <div id="committee-container" class="space-y-4">
                        @php
                            $committees = [
                                'Committee Chair Infrastructure & Finance',
                                'Committee Chair on Barangay Affairs & Environment',
                                'Committee Chair on Education',
                                'Committee Chair Peace & Order',
                                'Committee Chair on Laws & Good Governance',
                                'Committee Chair on Elderly, PWD/VAWC',
                                'Committee Chair on Health & Sanitation/ Nutrition',
                                'Committee Chair on Livelihood',
                            ];
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($committees as $committee)
                                <div class="flex items-center justify-between bg-gray-100 p-3 rounded-md">
                                    <span class="text-gray-700">{{ $committee }}</span>
                                    <input type="text" name="{{ Str::snake($committee) }}"
                                        class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="₱0.00" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Calendar of Activities -->
                    <div class="mt-5">
                        <button type="button"
                            onclick="window.location.href='{{ route('Official.CalendarActivities.index') }}'"
                            class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500">
                            Calendar of Activities
                        </button>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-8 text-right">
                        <button type="button"
                            class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500"
                            onclick="document.getElementById('my_modal_2').showModal()">
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
                                    onclick="document.getElementById('my_modal_2').close(); document.getElementById('addTransactionForm').submit();">
                                    Yes
                                </button>

                            </div>
                        </div>
                    </dialog>
                </form>


                <!-- External JavaScript -->
                <script>
                    // Function to close the modal
                    // Function to close the modal
                    function closeModal() {
                        const modal = document.getElementById('my_modal_2');
                        modal.close(); // Close the modal
                    }

                    // Format yearly budget input
                    function formatExpenseAmount(input) {
                        let value = input.value.replace(/[^0-9.]/g, '');
                        const parts = value.split('.');
                        if (parts.length > 2) value = parts[0] + '.' + parts[1];
                        const [integerPart, decimalPart] = value.split('.');
                        const formattedInteger = integerPart ? parseInt(integerPart, 10).toLocaleString() : '';
                        input.value = decimalPart !== undefined ? `₱${formattedInteger}.${decimalPart.slice(0, 2)}` :
                            `₱${formattedInteger}`;
                    }

                    // Distribute budget equally among committees and update percentages
                    document.getElementById('yearly_budget').addEventListener('input', function() {
                        const yearlyBudget = parseFloat(this.value.replace(/[₱,]/g, '')) || 0;
                        const committeeInputs = document.querySelectorAll('.committee-input');
                        const dividedAmount = yearlyBudget / committeeInputs.length;

                        committeeInputs.forEach(input => {
                            input.value = dividedAmount ?
                                `₱${dividedAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}` : '';
                            updatePercentage(input, yearlyBudget); // Update percentage
                        });
                    });

                    // Update percentage dynamically when a committee budget is edited
                    document.querySelectorAll('.committee-input').forEach(input => {
                        input.addEventListener('input', function() {
                            const yearlyBudget = parseFloat(document.getElementById('yearly_budget').value.replace(
                                /[₱,]/g, '')) || 0;
                            updatePercentage(this, yearlyBudget);
                        });
                    });

                    // Function to calculate and display percentage
                    function updatePercentage(input, yearlyBudget) {
                        const allocatedAmount = parseFloat(input.value.replace(/[₱,]/g, '')) || 0;
                        const percentage = yearlyBudget ? ((allocatedAmount / yearlyBudget) * 100).toFixed(2) : 0;

                        // Find the percentage display element
                        let percentageDisplay = input.nextElementSibling;
                        if (!percentageDisplay || !percentageDisplay.classList.contains('percentage-display')) {
                            // Create a percentage display element if it doesn't exist
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


                    // Remove formatting before form submission
                    document.getElementById('addTransactionForm').addEventListener('submit', function(e) {
                        const budgetInput = document.querySelector('input[name="yearly_budget"]');
                        if (budgetInput) budgetInput.value = budgetInput.value.replace(/[₱,]/g, '');

                        const committeeInputs = document.querySelectorAll('.committee-input');
                        committeeInputs.forEach(input => {
                            input.value = input.value.replace(/[₱,]/g, ''); // Remove formatting
                        });
                    });
                </script>
</x-app-layout>
