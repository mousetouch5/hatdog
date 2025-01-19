<!-- Year and Yearly Budget Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-20">
    <!-- Year Input -->
    <div>
        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year:</label>
        <select id="year" name="year"
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" readonly>
            <option value="{{ $currentYear }}" selected>{{ $currentYear }}</option>
        </select>
    </div>

    <!-- Yearly Budget Input -->
    <div>
        <label for="yearly_budget" class="block text-sm font-medium text-gray-700 mb-1">Year Budget:</label>
        <input type="text" id="yearly_budget" name="yearly_budget"
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
            value="₱{{ number_format($totalBudget->amount ?? 0, 2) }}" readonly>
    </div>

</div>




<div class="space-y-4">
    <!-- Header Row -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 font-semibold text-gray-700">
        <span>Committee</span>
        <span class="text-center">Allocated Budget</span>
        <span class="text-center">Remaining Balance</span>
    </div>



    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach ($committeesData as $data)
            <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                <!-- Display the original committee name -->
                <span class="text-gray-700">{{ $data['committee_name'] }}</span>
            </div>
            <div class="flex gap-2">
                <!-- Price input field for budget -->
                <input type="text" name="{{ Str::snake($data['committee_name']) }}_price"
                    class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500"
                    value="₱{{ number_format($data['budget'], 2) }}" readonly>
                <!-- New input field for remaining budget -->
                <input type="text" name="{{ Str::snake($data['committee_name']) }}_additional"
                    class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500"
                    value="₱{{ number_format($data['remaining_budget'], 2) }}" readonly>

                <!-- Edit Button -->
                <div class="mt-2">
                    <button
                        onclick="openChangeComitteeModal('{{ $data['committee_name'] }}', {{ $data['budget'] }}); console.log('Edit button clicked');"
                        class="bg-indigo-500 text-white py-1 px-4 rounded-md hover:bg-indigo-600 focus:outline-none">
                        Edit
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div id="changeBudgetValue" class="modal hidden fixed inset-0 z-50 flex items-center justify-center"
        style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-box relative w-full max-w-lg p-6 bg-white rounded-md shadow-lg">
            <button type="button" onclick="closeChangeComitteeModal()"
                class="absolute top-4 right-4 text-2xl cursor-pointer">&times;</button>
            <div class="modal-header">
                <h2 class="text-3xl font-semibold text-gray-800">Change Committee Budget</h2>
            </div>
            <div class="modal-body mt-4">
                <p class="text-gray-600 mb-4">Enter the budget for <span id="committeeName"
                        class="font-semibold"></span></p>
                <input type="number" id="newBudget"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500"
                    placeholder="Enter new budget">
            </div>
            <div class="modal-footer mt-4 flex justify-end">
                <button onclick="saveBudget()"
                    class="bg-indigo-500 text-white py-2 px-6 rounded-md hover:bg-indigo-600 focus:outline-none">
                    Save
                </button>
                <button onclick="closeChangeComitteeModal()"
                    class="bg-gray-500 text-white py-2 px-6 ml-2 rounded-md hover:bg-gray-600 focus:outline-none">
                    Cancel
                </button>
            </div>
        </div>
    </div>


    <script>
        function logModalState() {
            const modal = document.getElementById("changeBudgetValue");
            console.log('Modal current state:', {
                element: modal,
                display: modal.style.display,
                classList: modal.classList.toString(),
                computedStyle: window.getComputedStyle(modal).display
            });
        }
        // Add this at the start of your JavaScript to help with debugging
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM fully loaded');
            // Verify modal exists
            const modal = document.getElementById("changeBudgetValue");
            console.log('Modal element:', modal);
        });

        function openChangeComitteeModal(committeeName, budget) {
            console.log('Opening modal for:', committeeName, budget);

            const modal = document.getElementById("changeBudgetValue");
            const committeeNameSpan = document.getElementById("committeeName");
            const budgetInput = document.getElementById("newBudget");

            if (!modal || !committeeNameSpan || !budgetInput) {
                console.error("Required elements not found:", {
                    modal: !!modal,
                    committeeNameSpan: !!committeeNameSpan,
                    budgetInput: !!budgetInput
                });
                return;
            }

            committeeNameSpan.textContent = committeeName;
            budgetInput.value = budget;

            // Force the modal to be visible
            modal.style.display = 'flex';
            modal.classList.remove("hidden");

            console.log('Modal should now be visible');
        }

        function closeChangeComitteeModal() {
            const modal = document.getElementById("changeBudgetValue");
            if (!modal) {
                console.error("Modal element not found!");
                return;
            }

            // Reset the modal state
            modal.style.display = 'none';
            modal.classList.add("hidden");
        }

        function saveBudget() {
            const budgetInput = document.getElementById("newBudget");
            if (!budgetInput) {
                console.error("Budget input not found!");
                return;
            }

            const newBudget = budgetInput.value;
            if (!newBudget) {
                alert("Please enter a valid budget amount");
                return;
            }

            // Format the budget with the peso sign and decimals
            const formattedBudget = new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP'
            }).format(newBudget);

            alert(`Budget updated to: ${formattedBudget}`);
            closeChangeComitteeModal();
        }
    </script>




    <div class="mt-5">
        <button type="button" onclick="window.location.href='{{ route('Official.CalendarActivities.index') }}'"
            class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500">
            Calendar of Activities
        </button>
    </div>
