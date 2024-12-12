    <!-- Budget Breakdown Modal -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <dialog id="budgetModal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Budget Breakdown</h3>
            <div class="space-y-4">
                <!-- Event Name -->
                <div>
                    <label for="eventName" class="block text-sm font-medium text-gray-700">Event</label>
                    <input type="text" id="eventName" class="input input-bordered w-full" readonly>
                </div>

                <!-- Budget Table -->
                <div>
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="expenseTableBody">
                            <!-- Expense rows will be inserted dynamically here -->
                        </tbody>
                    </table>
                </div>

                <!-- Budget Summary -->
                <div>
                    <label for="totalBudget" class="block text-sm font-medium text-gray-700">Total Budget</label>
                    <input type="text" id="totalBudget" class="input input-bordered w-full" readonly>
                </div>
                <div>
                    <label for="totalSpent" class="block text-sm font-medium text-gray-700">Total Spent</label>
                    <input type="text" id="totalSpent" class="input input-bordered w-full" readonly>
                </div>
                <div>
                    <label for="remainingBudget" class="block text-sm font-medium text-gray-700">Remaing Budget</label>
                    <input type="text" id="remainingBudget" class="input input-bordered w-full" readonly>
                </div>

                <div class="modal-action">
                    <form method="dialog">
                        <button class="btn">Close</button>
                        <button id="markAsDoneBtn" class="btn btn-success hidden" onclick="markEventAsDone()">
                            Mark as Done
                        </button>
                    </form>
                </div>
                <div>
                    <button class="btn" id="bts" onclick="showUpdateModal()">Update</button>
                </div>
            </div>
        </div>

    </dialog>
    </div>









    <script>
        function markEventAsDone() {
            // Assuming the event ID is stored somewhere, such as in a global variable or hidden input

            const eventId = currentEventData.eventId;
            console.log(eventId);
            if (!eventId) {
                alert("Event ID is missing. Cannot update status.");
                return;
            }

            // PUT Request to update event status to 'done'
            fetch(`/events/${eventId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // CSRF for Laravel
                    },
                    body: JSON.stringify({
                        status: 'done'
                    }) // Update payload
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Event status has been updated to 'done'.");
                        document.getElementById('markAsDoneBtn').disabled = true; // Disable button after success
                    } else {
                        console.log("Failed to update status: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error updating event status:", error);
                    alert("An error occurred while updating the event status.");
                });
        }
    </script>






    <!-- Modal HTML -->
    <dialog id="updateExpenseModal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Update Expense</h3>
            <form id="updateExpenseForm" method="POST">
                @csrf
                <!-- Expense Description -->
                <div class="space-y-4">
                    <div id="expense-container" class="mt-4">
                        <h4 class="text-md font-semibold text-gray-700">Expenses:</h4>
                        <div class="expense-item flex justify-between mt-2">
                            <input type="text" name="expenses[]" placeholder="Expense Description"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2">
                            <input type="text" name="expense_amount[]" placeholder="Price"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
                            <select name="expense_date[]"
                                class="expense-date-dropdown mt-1 block w-full px-4 py-2 border border-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2"></select>
                            <input type="time" name="expense_time[]"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
                        </div>
                    </div>
                    <button type="button" id="add-expense-button" onclick="addExpense()"
                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Add More
                    </button>

                    <div class="modal-action">
                        <button type="button" class="btn"
                            onclick="document.getElementById('updateExpenseModal').close()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Scripts -->
    <script>
        // Global object to hold event data

        let globalStartDate;
        let globalEndDate;

        function showUpdateModal() {
            const eventData = currentEventData;
            document.getElementById('updateExpenseModal').showModal();

            // Capture start and end dates
            globalStartDate = eventData.eventStartDate;
            globalEndDate = eventData.eventEndDate;

            // Populate existing dropdowns
            const dropdowns = document.querySelectorAll('.expense-date-dropdown');
            dropdowns.forEach(dropdown => {
                const dateOptions = generateDateOptions(globalStartDate, globalEndDate);
                populateDropdown(dropdown, dateOptions);
            });
        }


        // Function to generate date options between two dates
        function generateDateOptions(startDate, endDate) {
            const dateOptions = [];
            let currentDate = new Date(startDate);
            const endDateObj = new Date(endDate);

            // Loop through dates and push to array
            while (currentDate <= endDateObj) {
                const optionValue = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                dateOptions.push(optionValue);
                currentDate.setDate(currentDate.getDate() + 1); // Move to next day
            }

            return dateOptions;
        }

        // Function to populate the dropdown with date options
        function populateDropdown(dropdown, options) {
            dropdown.innerHTML = ''; // Clear existing options
            options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option;
                optionElement.textContent = option;
                dropdown.appendChild(optionElement);
            });
        }

        function addExpense() {
            const expenseContainer = document.getElementById('expense-container');
            const newExpenseItem = document.createElement('div');
            newExpenseItem.className = 'expense-item flex justify-between mt-2';

            newExpenseItem.innerHTML = `
        <input type='text' name='expenses[]' placeholder='Expense Description'
            class='mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2'>
        <input type='text' name='expense_amount[]' placeholder='Price'
            class='mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2'>
        <select name="expense_date[]"
            class="expense-date-dropdown mt-1 block w-full px-4 py-2 border border-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2"></select>
        <input type='time' name='expense_time[]'
            class='mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2'>
    `;

            expenseContainer.appendChild(newExpenseItem);

            // Populate the newly added dropdown with dates using global variables
            const newDropdown = newExpenseItem.querySelector('.expense-date-dropdown');
            const dateOptions = generateDateOptions(globalStartDate, globalEndDate);
            populateDropdown(newDropdown, dateOptions);
        }



        document.getElementById('updateExpenseForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('event_id', currentEventData.eventId); // Add event_id to the form data

            fetch('/update-expense', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // Ensure you have the CSRF token in the meta tag
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors) {
                        alert('Error: ' + JSON.stringify(data.errors));
                    } else {
                        alert(data.message);
                        document.getElementById('updateExpenseModal')
                            .close(); // Close modal after successful submission
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error saving the expenses.');
                });
        });
    </script>





    <style>
        /* Modal box customization */
        .modal-box {
            width: 80%;
            max-width: 800px;
            max-height: 80vh;
            padding: 20px;
            overflow-y: auto;
        }

        /* Increase size of inputs */
        .expense-date-dropdown,
        input[type="time"],
        input[type="text"] {
            width: 100%;
            padding: 12px;
            font-size: 1.2rem;
            /* Bigger font */
        }

        /* Optional: Ensure modal background is semi-transparent */
        .modal {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
