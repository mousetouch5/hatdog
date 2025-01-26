<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-20">
    <!-- Year Input -->
    <div>
        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year:</label>
        <form method="GET" action="{{ route('Official.BudgetPlanning.index') }}">
            <select id="year" name="year"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                onchange="this.form.submit()">
                @foreach ($availableYears as $year)
                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                        {{ $year }}</option>
                @endforeach
            </select>
        </form>
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
        <span>Allocated Budget</span>
        <span>Remaining Balance</span>
    </div>

    <!-- Loop through the committees data and display each committee's details -->
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
                <!-- Edit Button -->
                <div class="mt-2">
                    @if ($selectedYear == now()->year)
                        <button
                            onclick="openChangeComitteeModal('{{ $data['committee_name'] }}', {{ $data['remaining_budget'] }})"
                            class="bg-indigo-500 text-white py-1 px-4 rounded-md hover:bg-indigo-600 focus:outline-none">
                            Edit
                        </button>
                    @endif
                </div>

            </div>
        @endforeach
    </div>
</div>


<form id="change-budget-form" method="POST" action="{{ route('update.committee.budget') }}">
    @csrf
    <dialog id="changeBudgetValue" class="modal fixed inset-0 z-50 flex items-center justify-center">
        <div class="modal-box relative w-full max-w-lg p-6 bg-white rounded-md shadow-lg">
            <button type="button" onclick="closeChangeComitteeModal()"
                class="absolute top-4 right-4 text-2xl cursor-pointer">&times;</button>
            <div class="modal-header">
                <h2 class="text-2xl font-semibold text-gray-800">Change Committee Budget</h2>
            </div>
            <div class="modal-body mt-3">
                <p class="text-gray-600 mb-2">Potted Budget Left</p>
                <p id="total-budget" class="text-gray-600 font-medium mb-3">₱0.00</p>
                <p class="text-gray-600 mb-2">Value to be distributed for everyone</p>
                <p id="total-remaining" class="text-gray-600 font-medium mb-3">₱0.00</p>
                <p class="text-gray-600 mb-2">Enter the budget for <span id="committeeName"
                        class="font-semibold"></span></p>
                <input type="number" id="newBudget" name="new_budget"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500"
                    placeholder="Enter new budget" oninput="calculateRemaining()">

                <input type="hidden" id="committee_id" name="committee_id">
            </div>
            <div class="modal-footer mt-4 flex justify-end gap-2">
                <button type="submit"
                    class="bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 focus:outline-none">
                    Save
                </button>

                <button type="button" onclick="closeChangeComitteeModal()"
                    class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none">
                    Cancel
                </button>
            </div>
        </div>
    </dialog>
</form>




<script>
    // Global variable to store total budget
    let totalBudget = 0;

    function calculateRemaining() {
        const newBudget = parseFloat(document.getElementById("newBudget").value) || 0;
        const remaining = totalBudget - newBudget;

        // Update the remaining value
        document.getElementById("total-remaining").textContent =
            `₱${remaining.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        function fetchTotalBudget() {
            fetch('/totalbudgetleft')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    const totalBudgetElement = document.getElementById('total-budget');
                    if (typeof data.totalBudgetLeft === 'number') {
                        // Store the fetched total budget in the global variable
                        totalBudget = data.totalBudgetLeft;

                        // Format and display the budget
                        const formattedBudget = new Intl.NumberFormat('en-PH', {
                            style: 'currency',
                            currency: 'PHP',
                        }).format(totalBudget);
                        totalBudgetElement.textContent = formattedBudget;
                    } else {
                        console.warn('Invalid totalBudgetLeft value:', data.totalBudgetLeft);
                        totalBudgetElement.textContent = '₱0.00';
                        totalBudget = 0;
                    }
                })
                .catch(error => {
                    console.error('Error fetching total budget:', error);
                    document.getElementById('total-budget').textContent = '₱0.00';
                    totalBudget = 0;
                });
        }

        // Fetch the budget on page load
        fetchTotalBudget();

        // Recalculate remaining budget when user inputs a new budget
        document.getElementById('newBudget').addEventListener('input', calculateRemaining);
    });





    function openChangeComitteeModal(committeeName, budget) {
        const dialog = document.getElementById('changeBudgetValue');
        const committeeNameSpan = document.getElementById('committeeName');
        const budgetInput = document.getElementById('newBudget');
        const committeeIdInput = document.getElementById('committee_id'); // Hidden input

        // Ensure required elements exist
        if (!dialog || !committeeNameSpan || !budgetInput || !committeeIdInput) {
            console.error('Required elements not found:', {
                dialog: !!dialog,
                committeeNameSpan: !!committeeNameSpan,
                budgetInput: !!budgetInput,
                committeeIdInput: !!committeeIdInput
            });
            return;
        }

        // Set values
        committeeNameSpan.textContent = committeeName;
        budgetInput.value = '';
        committeeIdInput.value = committeeName; // Set hidden input value

        // Show modal
        dialog.showModal();
    }


    function closeChangeComitteeModal() {
        const dialog = document.getElementById('changeBudgetValue');

        if (!dialog) {
            console.error('Modal element not found!');
            return;
        }

        // Close the modal
        dialog.close();
    }


    // Submit the form via AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById("change-budget-form");

        // Submit the form via AJAX
        form.addEventListener("submit", async function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                            .value,
                    },
                    body: formData,
                });

                const result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        title: 'Success!',
                        text: result.message || 'Budget updated successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    closeChangeComitteeModal(); // Close modal after success
                } else {
                    let errorMessages = Object.values(result.errors || {}).map(err =>
                        `<p>${err}</p>`).join("");

                    Swal.fire({
                        title: 'Error!',
                        html: errorMessages || (result.message || 'An error occurred.'),
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: 'Oops!',
                    text: 'An unexpected error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
<div class="mt-5">
    <button type="button" onclick="window.location.href='{{ route('Official.CalendarActivities.index') }}'"
        class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500">
        Calendar of Activities
    </button>
</div>


<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css">

<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>
