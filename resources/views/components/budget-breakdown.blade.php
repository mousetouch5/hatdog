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
                                <th>Quantity</th>
                                <th>Value</th>
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
            <form id="updateExpenseForm" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Expense Description -->
                <div class="space-y-4">
                    <div id="expense-container" class="mt-4">

                        <div class="mb-4">
                            <label for="reciept" class="block text-sm font-semibold text-gray-700">Reciept
                                Image:</label>
                            <input type="file" id="reciept" name="reciept"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                            @error('reciept')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <h4 class="text-md font-semibold text-gray-700">Expenses:</h4>
                        <div id="total-expenses" class="text-md font-bold text-green-700 mt-2">
                            Total: ₱0
                        </div>
                        <div class="expense-item flex justify-between mt-2">
                            <input type="text" name="expenses[]" placeholder="Expense Description"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2">
                            <input type="text" name="expense_amount[]" placeholder="Price"
                                oninput="formatExpenseAmount(this); updateTotalExpenses();"
                                class="expense-amount mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
                            <input type="date" name="expense_date[]"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <input type="time" name="expense_time[]"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
                            <input type="number" name="quantity_amount[]" placeholder="Quantity" value="1"
                                min="1" oninput="updateTotalExpenses()"
                                class="quantity-amount mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
                            <button class="btn btn-circle" onclick="nothing(event)" style="visibility: hidden;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
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
        function nothing(event) {
            event.preventDefault();
        }


        function showUpdateModal() {
            const eventData = currentEventData;
            document.getElementById('updateExpenseModal').showModal();

        }


        function updateTotalExpenses() {
            const expenseRows = document.querySelectorAll('.expense-item');
            let total = 0;

            expenseRows.forEach(row => {
                const hiddenInput = row.querySelector('input[name="expense_amount_raw[]"]');
                const quantityInput = row.querySelector('.quantity-amount');

                const amount = parseFloat(hiddenInput?.value || '0');
                const quantity = parseInt(quantityInput.value) || 1;

                total += amount * quantity;
            });

            const totalDisplay = document.getElementById('total-expenses');
            totalDisplay.textContent = new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP'
            }).format(total);
        }



        function formatExpenseAmount(input) {
            // Remove any non-digit characters except for the period
            let value = input.value.replace(/[^0-9.]/g, '');

            // Ensure only one decimal point
            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }

            // Limit decimal places to 2
            if (parts.length === 2) {
                value = parts[0] + '.' + parts[1].slice(0, 2);
            }

            // Convert to number and format display value
            const number = parseFloat(value) || 0;
            const formattedValue = number.toLocaleString('en-PH', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // Create or update the hidden input for raw value
            let hiddenInput = input.parentElement.querySelector('input[name="expense_amount_raw[]"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'expense_amount_raw[]';
                input.parentElement.appendChild(hiddenInput);
            }
            hiddenInput.value = number.toFixed(2);

            // Update display value
            input.value = formattedValue;
        }


        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            const expenseRows = document.querySelectorAll('.expense-item');

            expenseRows.forEach((row, index) => {
                const amountInput = row.querySelector('.expense-amount');
                const rawAmount = getNumericValue(amountInput);

                // Create hidden input for raw amount
                const hiddenAmount = document.createElement('input');
                hiddenAmount.type = 'hidden';
                hiddenAmount.name = `expense_amount_raw[]`;
                hiddenAmount.value = rawAmount.toFixed(2);
                row.appendChild(hiddenAmount);

                // Validate required fields
                const description = row.querySelector('input[name="expenses[]"]').value.trim();
                const date = row.querySelector('input[name="expense_date[]"]').value;
                const time = row.querySelector('input[name="expense_time[]"]').value;

                if (!description || !date || !time || rawAmount <= 0) {
                    e.preventDefault();
                    alert('Please fill in all required fields for expense item ' + (index + 1));
                    return;
                }
            });

            // If validation passes, submit the form
            this.submit();
        });




        function addExpense() {
            const expenseContainer = document.getElementById('expense-container');
            const newExpenseItem = document.createElement('div');
            newExpenseItem.className = 'expense-item flex justify-between mt-2';

            newExpenseItem.innerHTML = `
        <input type="text" name="expenses[]" required placeholder="Expense Description"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2">
        <input type="text" name="expense_amount[]" required placeholder="Price"
            oninput="formatExpenseAmount(this); updateTotalExpenses();"
            class="expense-amount mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
        <input type="date" name="expense_date[]" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="time" name="expense_time[]" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
        <input type="number" name="quantity_amount[]" placeholder="Quantity" value="1" min="1"
            oninput="updateTotalExpenses()" required
            class="quantity-amount mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
        <button type="button" class="btn btn-circle" onclick="removeExpense(this)">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;

            expenseContainer.appendChild(newExpenseItem);
        }



        function removeExpense(button) {
            button.closest('.expense-item').remove();
            updateTotalExpenses();
        }





        function prepareFormData(formElement) {
            const formData = new FormData(formElement);
            const expenses = [];
            const expenseRows = document.querySelectorAll('.expense-item');

            expenseRows.forEach((row, index) => {
                const description = row.querySelector('[name="expenses[]"]').value;
                const amountInput = row.querySelector('[name="expense_amount[]"]');
                const date = row.querySelector('[name="expense_date[]"]').value;
                const time = row.querySelector('[name="expense_time[]"]').value;
                const quantity = row.querySelector('[name="quantity_amount[]"]').value;

                // Get clean numeric value without currency formatting
                const rawAmount = getNumericValue(amountInput);

                // Create expense object
                expenses.push({
                    description: description,
                    amount: rawAmount.toFixed(2), // Clean numeric value for database
                    date: date,
                    time: time,
                    quantity: quantity
                });
            });

            // Add expenses array to form data
            formData.append('expenses_data', JSON.stringify(expenses));

            // Clean up budget value
            const budgetInput = document.getElementById('event_budget');
            if (budgetInput) {
                const rawBudget = getNumericValue(budgetInput);
                formData.set('budget', rawBudget.toFixed(2));
            }

            return formData;
        }







        document.querySelector('form').addEventListener('submit', function(e) {
            const expenseRows = document.querySelectorAll('.expense-item');
            let isValid = true;

            expenseRows.forEach((row, index) => {
                const description = row.querySelector('[name="expenses[]"]').value.trim();
                const amount = row.querySelector('[name="expense_amount_raw[]"]')?.value;
                const date = row.querySelector('[name="expense_date[]"]').value;
                const time = row.querySelector('[name="expense_time[]"]').value;
                const quantity = row.querySelector('[name="quantity_amount[]"]').value;

                if (!description || !amount || !date || !time || !quantity) {
                    isValid = false;
                    alert(`Please fill in all required fields for expense item ${index + 1}`);
                }
            });

            if (!isValid) {
                e.preventDefault();
                return false;
            }
        });




        function validateForm(form) {
            let isValid = true;
            const expenseRows = form.querySelectorAll('.expense-item');

            expenseRows.forEach((row, index) => {
                const description = row.querySelector('[name="expenses[]"]').value.trim();
                const amount = getNumericValue(row.querySelector('[name="expense_amount[]"]'));
                const date = row.querySelector('[name="expense_date[]"]').value;
                const time = row.querySelector('[name="expense_time[]"]').value;
                const quantity = parseInt(row.querySelector('[name="quantity_amount[]"]').value);

                if (!description || amount <= 0 || !date || !time || quantity < 1) {
                    alert(`Please fill in all required fields for expense item ${index + 1}`);
                    isValid = false;
                }
            });

            return isValid;
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
