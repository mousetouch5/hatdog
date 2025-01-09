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
                            <label for="yearly_budget" class="block text-sm font-medium text-gray-700 mb-1">Yearly
                                Budget:</label>
                            <input type="text" id="yearly_budget" name="yearly_budget"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter Budget" oninput="formatExpenseAmount(this)" required />
                        </div>
                    </div>

                    <!-- Allocated Budget Section -->
                    <h3 class="text-lg font-semibold mb-6">Allocated Budget</h3>
                    <div id="committee-container" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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

                            @foreach ($committees as $committee)
                                <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                                    <span class="text-gray-700">{{ $committee }}</span>

                                </div>
                                <input type="text" name="{{ Str::snake($committee) }}"
                                    class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="₱0.00" />
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
                            onclick="my_modal_2.showModal()">
                            Save
                        </button>
                    </div>


                    <dialog id="my_modal_2" class="modal">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Confirmation</h3>
                            <p class="py-4">Please review the following information carefully. Do you want to save
                                these changes?</p>
                            <div class="modal-action">
                                <!-- Cancel Button -->
                                <button class="btn" type="button" onclick="closeModal()">No</button>


                                <!-- Confirm Button -->
                                <button type="submit" class="btn btn-primary bg-gray-700" id="confirmSave">Yes</button>
                            </div>
                        </div>
                    </dialog>
                </form>
            </div>
        </div>
    </div>

    <!-- External JavaScript -->
    <script>
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

        // Distribute budget equally among committees
        document.getElementById('yearly_budget').addEventListener('input', function() {
            const yearlyBudget = parseFloat(this.value.replace(/[₱,]/g, '')) || 0;
            const committeeInputs = document.querySelectorAll('.committee-input');
            const dividedAmount = yearlyBudget / committeeInputs.length;
            committeeInputs.forEach(input => {
                input.value = dividedAmount ?
                    `₱${dividedAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}` : '';
            });
        });

        // Remove formatting before form submission
        document.getElementById('addTransactionForm').addEventListener('submit', function(e) {
            const budgetInput = document.querySelector('input[name="yearly_budget"]');
            if (budgetInput) budgetInput.value = budgetInput.value.replace(/[₱,]/g, '');
        });
    </script>
</x-app-layout>
