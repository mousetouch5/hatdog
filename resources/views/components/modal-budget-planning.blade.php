<div class="flex justify-end mt-5">
    <button class="bg-gray-700 text-white px-6 py-2 rounded shadow hover:bg-blue-600 transition"
        onclick="my_modal_5.showModal()">Add</button>
</div>

<!-- Modal -->
<dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box w-11/12 max-w-5xl">

        <h3 class="text-lg font-bold py-4">Budget Planning</h3>

        <form id="event-form" method="dialog" class="space-y-4">
            <!-- Title -->
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
                <input type="date" id="date" name="eventEndDate" class="w-80 border rounded px-3 py-2" required>
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

            <!-- Possible Expenses -->
            <div class="space-y-5" id="expense-container">
                <label class="block font-medium mb-2">Possible Expenses</label>
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                    <!-- Category Selection -->
                    <div class="flex flex-col">
                        <label for="category" class="block text-sm font-medium">Category</label>
                        <select id="category" name="category" class="border rounded px-3 py-2 w-full" required>
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
                        <input type="text" id="item" name="item" class="border rounded px-3 py-2 w-full"
                            placeholder="Enter item/type" required>
                    </div>
                    <!-- Quantity -->
                    <div class="flex flex-col">
                        <label for="quantity" class="block text-sm font-medium">Quantity</label>
                        <input type="number" id="quantity" name="quantity" class="border rounded px-3 py-2 w-full"
                            placeholder="Enter quantity" required>
                    </div>
                    <!-- Amount -->
                    <div class="flex flex-col">
                        <label for="amount" class="block text-sm font-medium">Amount</label>
                        <input type="number" id="amount" name="amount" class="border rounded px-3 py-2 w-full"
                            placeholder="Enter amount" required>
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
    // Script to calculate and display total expense

    function nothing(event) {
        event.preventDefault();
    }


    function addExpense() {
        const expenseContainer = document.getElementById('expense-container');
        const newExpenseItem = document.createElement('div');
        newExpenseItem.className = 'expense-item flex justify-between mt-2';

        newExpenseItem.innerHTML = `



        <div class="flex flex-col">
                        <label for="category" class="block text-sm font-medium">Category</label>
                        <select id="category" name="category" class="border rounded px-3 py-2 w-full" required>
                            <option value="" disabled selected>Select category</option>
                            <option value="office_supplies">Office Supplies</option>
                            <option value="travel">Travel</option>
                            <option value="utilities">Utilities</option>
                            <option value="miscellaneous">Miscellaneous</option>
                      </select>
          </div>

          <div class="flex flex-col">
             <label for="item" class="block text-sm font-medium">Item/Type</label>
                        <input type="text" id="item" name="item" class="border rounded px-3 py-2 w-full"
                            placeholder="Enter item/type" required>
          </div>
           <div class="flex flex-col">
                        <label for="quantity" class="block text-sm font-medium">Quantity</label>
                        <input type="number" id="quantity" name="quantity" class="border rounded px-3 py-2 w-full"
                            placeholder="Enter quantity" required>
                    </div>
                    <!-- Amount -->
                    <div class="flex flex-col">
                        <label for="amount" class="block text-sm font-medium">Amount</label>
                        <input type="number" id="amount" name="amount" class="border rounded px-3 py-2 w-full"
                            placeholder="Enter amount" required>
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


    `;

        expenseContainer.appendChild(newExpenseItem);
    }
</script>


<style>


</style>
