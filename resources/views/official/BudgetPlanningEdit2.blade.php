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
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
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
                                placeholder="Enter Budget" oninput="formatExpenseAmount(this)">
                        </div>
                    </div>

                    <!-- Allocated Budget Section -->
                    <h3 class="text-lg font-semibold mb-6">Allocated Budget</h3>
                    <div class="space-y-4">
                        <!-- Repeatable Rows for Committees -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                                <span class="text-gray-700">Committee Chair Infrastructure & Finance</span>
                                <input type="text" name="committee_infrastructure_finance"
                                    class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                                <span class="text-gray-700">Committee Chair on Barangay Affairs & Environment</span>
                                <input type="text" name="committee_barangay_affairs"
                                    class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                                <span class="text-gray-700">Committee Chair on Education</span>
                                <input type="text" name="committee_education"
                                    class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                                <span class="text-gray-700">Committee Chair Peace & Order</span>
                                <input type="text" name="committee_peace_order"
                                    class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                                <span class="text-gray-700">Committee Chair on Laws & Good Governance</span>
                                <input type="text" name="committee_laws_governance"
                                    class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                                <span class="text-gray-700">Committee Chair on Elderly, PWD/VAWC</span>
                                <input type="text" name="committee_elderly_pwd"
                                    class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                                <span class="text-gray-700">Committee Chair on Health & Sanitation/ Nutrition</span>
                                <input type="text" name="committee_health_sanitation"
                                    class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                                <span class="text-gray-700">Committee Chair on Livelihood</span>
                                <input type="text" name="committee_livelihood"
                                    class="committee-input w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
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
                        <button type="submit"
                            class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('yearly_budget').addEventListener('input', function() {
            const yearlyBudget = parseFloat(this.value) || 0;
            const committeeInputs = document.querySelectorAll('.committee-input');
            const numberOfCommittees = committeeInputs.length;
            const dividedAmount = yearlyBudget / numberOfCommittees;

            committeeInputs.forEach(input => {
                // Format the dividedAmount with a peso sign, commas, and 2 decimal places
                const formattedAmount =
                    `₱${dividedAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
                input.value = formattedAmount;
            });

        });



        function formatExpenseAmount(input) {
            // Remove all non-digit characters except for the period
            let value = input.value.replace(/[^0-9.]/g, '');

            // Prevent more than one period in the value
            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts[1]; // Keep only the first two parts
            }

            // Split the value into integer and decimal parts
            const [integerPart, decimalPart] = value.split('.');

            // Format the integer part with commas
            const formattedInteger = integerPart ? parseInt(integerPart, 10).toLocaleString() : '';

            // Combine integer and decimal parts
            let formattedValue = decimalPart !== undefined ?
                `${formattedInteger}.${decimalPart.slice(0, 2)}` // Limit decimals to two places
                :
                formattedInteger;

            // Prepend the peso sign and update the input field
            input.value = formattedValue ? `₱${formattedValue}` : '';
        }

        // Remove formatting before submission
        document.getElementById('addTransactionForm').addEventListener('submit', function(e) {
            const budgetInput = document.querySelector('input[name="yearly_budget"]');
            if (budgetInput) {
                // Remove peso sign and commas
                budgetInput.value = budgetInput.value.replace(/[₱,]/g, '');
            }
        });
    </script>
</x-app-layout>
