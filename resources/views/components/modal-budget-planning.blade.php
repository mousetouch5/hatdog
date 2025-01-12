<div class="flex justify-end mt-5">
    <button class="bg-gray-700 text-white px-6 py-2 rounded shadow hover:bg-blue-600 transition"
        onclick="my_modal_5.showModal()">Add</button>
</div>

<!-- Modal -->
<dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box w-11/12 max-w-5xl">

        <h3 class="text-lg font-bold py-4">Budget Planning</h3>

        <form method="POST" class="space-y-4"action="{{ route('fakeevents.store') }}">
            @csrf

            <input type="hidden" name="eventDescription" value="wrong_value">
            <!-- Title -->
            <div class="flex flex-col items-center justify-center ">
                <div>
                    <label for="title" class="block font-medium">Title</label>
                    <input type="text" id="title" name="eventName" class="w-80 border rounded px-3 py-2"
                        placeholder="Enter event title" required>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block font-medium">Start Date</label>
                    <input type="date" id="date" name="eventStartDate" class="w-80 border rounded px-3 py-2"
                        required>
                </div>

                <div>
                    <label for="date" class="block font-medium">End Date</label>
                    <input type="date" id="date" name="eventEndDate" class="w-80 border rounded px-3 py-2"
                        required>
                </div>

                <div>
                    <label for="title" class="block font-medium">Organizer</label>
                    <input type="text" id="organizer" name="organizer" class="w-80 border rounded px-3 py-2"
                        placeholder="Enter organizer" required>
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block font-medium">Type</label>
                    <select id="type" name="type" class="w-80 border rounded px-3 py-2" required>
                        <option value="" disabled selected>Select type</option>
                        <option value="event">Event</option>
                        <option value="project">Project</option>
                    </select>
                </div>
            </div>

            <!-- Possible Expenses -->
            <div class="space-y-5" id="expense-container">
                <label class="block font-medium mb-2">Possible Expenses</label>
                <div id="total-expenses" class="text-md font-bold text-green-700 mt-2">
                    Total: ₱0
                </div>
                <div class="expense-item grid grid-cols-1 sm:grid-cols-5 gap-4 ">
                    <!-- Category Selection -->
                    <div class="flex flex-col">
                        <label for="category" class="block text-sm font-medium">Category</label>
                        <select id="category" name="expense_category[]" class="border rounded px-3 py-2 w-full"
                            required>
                            <option value="" disabled selected>Select category</option>
                            <option value="office_supplies">Office Supplies</option>
                            <option value="travel">Travel</option>
                            <option value="utilities">Utilities</option>
                            <option value="miscellaneous">Miscellaneous</option>
                        </select>
                    </div>
                    <!-- Item/Type -->
                    <div class="flex flex-col">
                        <label for="item" class="block text-sm font-medium">Item/Type</label>
                        <input type="text" id="item" name="expenses[]" class="border rounded px-3 py-2 w-full"
                            placeholder="Enter item/type" required>
                    </div>
                    <!-- Quantity -->
                    <div class="flex flex-col">
                        <label for="quantity" class="block text-sm font-medium">Quantity</label>
                        <input type="number" id="quantity" name="quantity_amount[]"
                            class="quantity-amount border rounded px-3 py-2 w-full" placeholder="Enter quantity"
                            required oninput="updateTotalExpenses()" value="1" min="1">
                    </div>
                    <!-- Amount -->
                    <div class="flex
                            flex-col">
                        <label for="amount" class="block text-sm font-medium">Amount</label>
                        <input type="text" id="amount" name="expense_amount[]"
                            class="expense-amount border rounded px-3 py-2 w-full" placeholder="Enter amount" required
                            oninput="formatExpenseAmount(this); updateTotalExpenses();">
                    </div>
                    <div class="flex flex-col">
                        <button class="btn btn-circle" onclick="nothing(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>






            <div class="mt-3">
                <button type="button" id="add-expenses" onclick="addExpense()"
                    class="bg-gray-700 text-white px-6 py-2 rounded shadow hover:bg-blue-600 transition">
                    Add
                </button>
            </div>





            <!-- Total Expenses -->
            <div>
                <label for="total-expenses" class="block font-medium">Total Expenses</label>
                <input type="text" id="total-expenses" name="total-expenses"
                    class="w-80 border rounded px-3 py-2" readonly>
                <input type="hidden" id="raw_event_budget" name="budget">
            </div>

            <!-- Modal Actions -->
            <div class="modal-action flex justify-between">

                <!-- Save Button -->
                <button type="submit"
                    class="bg-gray-700 text-white  px-3 py-2 rounded shadow hover:bg-green-600 transition">
                    Save
                </button>

                <!-- Close Button -->
                <button type="button"
                    class="bg-gray-700 text-white  px-3 py-2 rounded shadow hover:bg-red-600 transition"
                    onclick="my_modal_5.close()">Close</button>
            </div>
        </form>
    </div>
</dialog>

<script>
    // Update total expenses whenever any input changes
    function updateTotalExpenses() {
        const expenseRows = document.querySelectorAll('.expense-item');
        let total = 0;

        expenseRows.forEach(row => {
            const amountInput = row.querySelector('.expense-amount');
            const quantityInput = row.querySelector('.quantity-amount');

            const amount = getNumericValue(amountInput);
            const quantity = parseInt(quantityInput.value) || 1;

            total += amount * quantity;
        });

        // Update the display total
        const totalDisplay = document.getElementById('total-expenses');
        if (totalDisplay) {
            totalDisplay.textContent = `Total: ${formatCurrency(total)}`;
        }

        // Update the total expenses input
        const totalInput = document.querySelector('input[name="total-expenses"]');
        if (totalInput) {
            totalInput.value = formatCurrency(total);
        }

        // Update the hidden budget input with raw value
        const budgetInput = document.querySelector('input[name="budget"]');
        if (budgetInput) {
            budgetInput.value = total.toFixed(2);
        }
    }

    function getNumericValue(input) {
        if (!input || !input.value) return 0;
        return parseFloat(input.value.replace(/[₱,\s]/g, '')) || 0;
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(value);
    }

    function formatExpenseAmount(input) {
        if (!input) return;

        let value = input.value.replace(/[₱,\s]/g, '');

        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }

        if (parts.length === 2) {
            value = parts[0] + '.' + parts[1].slice(0, 2);
        }

        const number = parseFloat(value) || 0;

        // Update hidden input for raw value
        let hiddenInput = input.parentElement.querySelector('input[name="expense_amount_raw[]"]');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'expense_amount_raw[]';
            input.parentElement.appendChild(hiddenInput);
        }
        hiddenInput.value = number.toFixed(2);

        input.value = formatCurrency(number);
        updateTotalExpenses();
    }

    function addExpense() {
        const expenseContainer = document.getElementById('expense-container');
        const newExpenseItem = document.createElement('div');
        newExpenseItem.className = 'expense-item grid grid-cols-1 sm:grid-cols-5 gap-4 mt-4';

        newExpenseItem.innerHTML = `
        <div class="flex flex-col">
            <label for="category" class="block text-sm font-medium">Category</label>
            <select name="expense_category[]" class="border rounded px-3 py-2 w-full" required>
                <option value="" disabled selected>Select category</option>
                <option value="office_supplies">Office Supplies</option>
                <option value="travel">Travel</option>
                <option value="utilities">Utilities</option>
                <option value="miscellaneous">Miscellaneous</option>
            </select>
        </div>
        <div class="flex flex-col">
            <label for="item" class="block text-sm font-medium">Item/Type</label>
            <input type="text" name="expenses[]" class="border rounded px-3 py-2 w-full" placeholder="Enter item/type" required>
        </div>
        <div class="flex flex-col">
            <label for="quantity" class="block text-sm font-medium">Quantity</label>
            <input type="number" name="quantity_amount[]" class="quantity-amount border rounded px-3 py-2 w-full" 
                placeholder="Enter quantity" required value="1" min="1" oninput="updateTotalExpenses()">
        </div>
        <div class="flex flex-col">
            <label for="amount" class="block text-sm font-medium">Amount</label>
            <input type="text" name="expense_amount[]" class="expense-amount border rounded px-3 py-2 w-full" 
                placeholder="Enter amount" required oninput="formatExpenseAmount(this)">
        </div>
        <div class="flex flex-col">
            <button type="button" class="btn btn-circle" onclick="removeExpense(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;

        expenseContainer.appendChild(newExpenseItem);
    }

    function removeExpense(button) {
        const row = button.closest('.expense-item');
        if (row) {
            row.remove();
            updateTotalExpenses();
        }
    }

    function validateForm(form) {
        if (!form) return false;

        const expenseRows = form.querySelectorAll('.expense-item');
        let isValid = true;

        if (expenseRows.length === 0) {
            alert('Please add at least one expense item');
            return false;
        }

        expenseRows.forEach((row, index) => {
            const category = row.querySelector('[name="expense_category[]"]').value;
            const description = row.querySelector('[name="expenses[]"]').value.trim();
            const amount = getNumericValue(row.querySelector('.expense-amount'));
            const quantity = parseInt(row.querySelector('.quantity-amount').value);

            if (!category || !description || amount <= 0 || quantity < 1) {
                alert(`Please fill in all required fields for expense item ${index + 1}`);
                isValid = false;
            }
        });

        return isValid;
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!validateForm(this)) {
            return;
        }

        const formData = new FormData(this);

        // Add raw expense values
        const expenses = [];
        document.querySelectorAll('.expense-item').forEach(row => {
            const expense = {
                category: row.querySelector('[name="expense_category[]"]').value,
                description: row.querySelector('[name="expenses[]"]').value,
                quantity: row.querySelector('.quantity-amount').value,
                amount: row.querySelector('input[name="expense_amount_raw[]"]').value
            };
            expenses.push(expense);
        });

        formData.append('expenses_data', JSON.stringify(expenses));

        // Submit the form
        fetch(this.action, {
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
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateTotalExpenses();
    });

    // Prevent form submission on delete button click
    function nothing(event) {
        event.preventDefault();
    }
</script>
