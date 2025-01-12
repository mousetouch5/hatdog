<section class="bg-white shadow-lg rounded-lg p-6 flex flex-col">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-semibold mb-6">Add New Event</h2>

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="Event">
            <input type="hidden" name="eventType" value="Conference">
            <label for="event_status" class="block text-sm font-semibold text-gray-700">Select Transactions:</label>
            <select id="transaction" name="transaction_id"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Select a Transaction --</option>
                @foreach ($transactions as $transaction)
                    <option value="{{ $transaction->id }}" data-item="{{ $transaction->description }}"
                        data-budget="{{ $transaction->budget }}" data-date="{{ $transaction->date }}">
                        {{ $transaction->description }}
                    </option>
                @endforeach
            </select>


            <div class="mb-4">
                <label for="event_name" class="block text-sm font-semibold text-gray-700">Event Name:</label>
                <input type="text" id="event_name" placeholder="Event Name" name="eventName"
                    class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md">
            </div>


            <!-- Event Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-semibold text-gray-700">Event Description:</label>
                <textarea id="description" name="eventDescription" placeholder="Enter Event Description" rows="4"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                @error('eventDescription')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Event Start Date -->
            <div class="mb-4">
                <label for="event_start_date" class="block text-sm font-semibold text-gray-700">Event Start
                    Date:</label>
                <input type="date" id="event_start_date" name="eventStartDate" readonly
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Event End Date -->
            <div class="mb-4">
                <label for="event_end_date" class="block text-sm font-semibold text-gray-700">Event End Date:</label>
                <input type="date" id="event_end_date" name="eventEndDate"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Event Time -->
            <div class="mb-4">
                <label for="event_time" class="block text-sm font-semibold text-gray-700">Event Time:</label>
                <input type="time" id="event_time" name="eventTime"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('eventTime')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="event_image" class="block text-sm font-semibold text-gray-700">Event Image:</label>
                <input type="file" id="event_image" name="eventImage"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('eventImage')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Event Location -->
            <div class="mb-4">
                <label for="event_location" class="block text-sm font-semibold text-gray-700">Event Location:</label>
                <input type="text" id="event_location" name="eventLocation" placeholder="Enter Event Location"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('eventLocation')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Event Organizer -->
            <div class="mb-4">
                <label for="event_organizer" class="block text-sm font-semibold text-gray-700">Event
                    Organizer:</label>
                <input type="text" id="event_organizer" name="organizer" placeholder="Enter Organizer Name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('eventOrganizer')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Event Budget and Expenses -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Event Budget:</h3>
                <div class="flex justify-between mt-4">
                    <div class="mb-4">
                        <label for="event_budget" class="block text-sm font-semibold text-gray-700">Project
                            Budget:</label>

                        <!-- Read-only formatted budget for display -->
                        <input type="text" id="event_budget" placeholder="Event Budget" name="formatted_budget"
                            class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md" readonly>

                        <!-- Hidden numeric input for raw budget value -->
                        <input type="hidden" id="raw_event_budget" name="budget">
                    </div>
                    <div class="w-full ml-2">
                        <input type="hidden" id="event_spent" name="eventSpent" value="3000"
                            placeholder="Enter Total Spent"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
            </div>


            <div class="mb-4">
                <label for="reciept" class="block text-sm font-semibold text-gray-700">Reciept Image:</label>
                <input type="file" id="reciept" name="reciept"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('reciept')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Event Image -->
            <div id="expense-container" class="mt-4">
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
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

            <div class="flex justify-center mt-8">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 w-full">
                    Save Event
                </button>
            </div>
            <script>
                function nothing(event) {
                    event.preventDefault();
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





                function getNumericValue(input) {
                    // Remove currency symbol and commas, then parse as float
                    return parseFloat(input.value.replace(/[^0-9.]/g, '')) || 0;
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

                // Add hidden fields for raw values before form submission
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
            </script>





            <script>
                // Add this function to prepare form data before submission
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

                // Modify form submission
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

                // Add validation function
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

                // Function to handle form submission
                function submitForm(formData) {
                    // You can use fetch or axios here to submit the form
                    // Example using fetch:
                    fetch(formElement.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = data.redirect || '/success';
                            } else {
                                alert(data.message || 'Error submitting form');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error submitting form');
                        });
                }
            </script>


            <script>
                //auto populate

                document.getElementById('transaction').addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const eventName = selectedOption.getAttribute('data-item');
                    const eventBudget = selectedOption.getAttribute('data-budget');
                    const eventStartDate = selectedOption.getAttribute('data-date');

                    // Populate the Event Name field
                    document.getElementById('event_name').value = eventName || '';

                    if (eventBudget) {
                        // Format the budget with commas and peso sign for display
                        const formattedBudget = new Intl.NumberFormat('en-PH', {
                            style: 'currency',
                            currency: 'PHP',
                            minimumFractionDigits: 2,
                        }).format(eventBudget);

                        document.getElementById('event_budget').value = formattedBudget;

                        // Set the raw numeric value for submission
                        document.getElementById('raw_event_budget').value = eventBudget;
                    } else {
                        document.getElementById('event_budget').value = '';
                        document.getElementById('raw_event_budget').value = '';
                    }

                    if (eventStartDate) {
                        // Convert the date to the correct format if needed
                        const formattedDate = new Date(eventStartDate).toISOString().split('T')[0]; // yyyy-MM-dd format
                        document.getElementById('event_start_date').value = formattedDate;
                    } else {
                        document.getElementById('event_start_date').value = '';
                    }
                });

                // No need to remove formatting on submission since the raw value is in the hidden field
            </script>
