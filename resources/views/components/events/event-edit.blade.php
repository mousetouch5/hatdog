<section class="bg-white shadow-lg rounded-lg p-6 flex flex-col">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-semibold mb-6">Add New Event</h2>

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="event_status" class="block text-sm font-semibold text-gray-700">Select Transactions:</label>
            <select id="transaction" name="transaction_id"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Select a Transaction --</option>
                @foreach ($transactions as $transaction)
                    <option value="{{ $transaction->id }}" data-item="{{ $transaction->description }}"
                        data-budget="{{ $transaction->budget }}">
                        {{ $transaction->description }}
                    </option>
                @endforeach
            </select>

            <!-- Event Name -->
            <div class="mb-4">
                <label for="event_status" class="block text-sm font-semibold text-gray-700">Event Status:</label>
                <select id="event_status" name="eventStatus"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="ongoing">Ongoing</option>
                    <option value="done">Done</option>
                </select>
                @error('eventStatus')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

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
                <input type="date" id="event_start_date" name="eventStartDate"
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

            <!-- Event Type -->
            <div class="mb-4">
                <label for="event_type" class="block text-sm font-semibold text-gray-700">Event Type:</label>
                <select id="event_type" name="eventType"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Select Event Type</option>
                    <option value="Conference">Conference</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Seminar">Seminar</option>
                    <option value="Community Outreach">Community Outreach</option>
                </select>
                @error('eventType')
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
                <label for="event_organizer" class="block text-sm font-semibold text-gray-700">Event Organizer:</label>
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
                        <label for="event_budget" class="block text-sm font-semibold text-gray-700">Event
                            Budget:</label>
                        <input type="text" id="event_budget" placeholder="Event Budget" name="budget"
                            class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div class="w-full ml-2">
                        <input type="hidden" id="event_spent" name="eventSpent" value="3000"
                            placeholder="Enter Total Spent"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
            </div>

            <!-- Event Image -->
            <div id="expense-container" class="mt-4">
                <h4 class="text-md font-semibold text-gray-700">Expenses:</h4>
                <div class="expense-item flex justify-between mt-2">
                    <input type="text" name="expenses[]" placeholder="Expense Description"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2">
                    <input type="text" name="expense_amount[]" placeholder="Price"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
                    <select name="expense_date[]"
                        class="expense-date-dropdown mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2"></select>
                    <input type="time" name="expense_time[]"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">
                </div>
            </div>

            <button type="button" id="add-expense-button"
                onclick="addExpense(document.getElementById('event_start_date').value, document.getElementById('event_end_date').value)"
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Add More
            </button>
            <script>
                // Initialize dateOptions outside the DOMContentLoaded listener so it's accessible
                let dateOptions = [];

                document.addEventListener('DOMContentLoaded', function() {
                    const startDateInput = document.getElementById('event_start_date');
                    const endDateInput = document.getElementById('event_end_date');

                    function populateDateDropdowns() {
                        const startDate = new Date(startDateInput.value);
                        const endDate = new Date(endDateInput.value);

                        // Exit if dates are invalid or the start date is after the end date
                        if (isNaN(startDate) || isNaN(endDate) || startDate > endDate) {
                            return;
                        }

                        dateOptions = []; // Reset dateOptions array
                        let currentDate = new Date(startDate);

                        // Generate all dates between startDate and endDate
                        while (currentDate <= endDate) {
                            dateOptions.push(currentDate.toISOString().split('T')[0]); // Format date as YYYY-MM-DD
                            currentDate.setDate(currentDate.getDate() + 1); // Increment the date by one day
                        }

                        // Populate the dropdowns with the generated date options
                        document.querySelectorAll('.expense-date-dropdown').forEach(dropdown => {
                            populateDropdown(dropdown, dateOptions);
                        });
                    }

                    // Populate dropdown with date options
                    function populateDropdown(dropdown, options) {
                        dropdown.innerHTML = ''; // Clear existing options
                        options.forEach(date => {
                            const option = document.createElement('option');
                            option.value = date;
                            option.textContent = date;
                            dropdown.appendChild(option);
                        });
                    }

                    // Event listeners for changes in the start or end date input fields
                    startDateInput.addEventListener('change', populateDateDropdowns);
                    endDateInput.addEventListener('change', populateDateDropdowns);
                });

                // Function to add a new expense input field with a dropdown
                function addExpense(startDate, endDate) {
                    const expenseContainer = document.getElementById('expense-container');
                    const newExpenseItem = document.createElement('div');
                    newExpenseItem.className = 'expense-item flex justify-between mt-2';

                    newExpenseItem.innerHTML = `
        <input type='text' name='expenses[]' placeholder='Expense Description'
            class='mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2'>
        <input type='text' name='expense_amount[]' placeholder='Price'
            class='mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2'>
        <select name="expense_date[]"
            class="expense-date-dropdown mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2"></select>
        <input type='time' name='expense_time[]'
            class='mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2'>
    `;

                    expenseContainer.appendChild(newExpenseItem);

                    // Populate the newly added dropdown with dates
                    const newDropdown = newExpenseItem.querySelector('.expense-date-dropdown');
                    const dateOptions = generateDateOptions(startDate, endDate); // Generate date options
                    populateDropdown(newDropdown, dateOptions);
                }

                // Helper function to generate date options based on the range
                function generateDateOptions(startDate, endDate) {
                    const options = [];
                    const start = new Date(startDate);
                    const end = new Date(endDate);

                    if (isNaN(start) || isNaN(end) || start > end) {
                        return options; // Return empty array if dates are invalid
                    }

                    let currentDate = new Date(start);
                    while (currentDate <= end) {
                        options.push(currentDate.toISOString().split('T')[0]); // Format as YYYY-MM-DD
                        currentDate.setDate(currentDate.getDate() + 1); // Increment by one day
                    }

                    return options;
                }

                // Helper function to populate a dropdown with options
                function populateDropdown(dropdown, options) {
                    dropdown.innerHTML = ''; // Clear existing options
                    options.forEach(date => {
                        const option = document.createElement('option');
                        option.value = date;
                        option.textContent = date;
                        dropdown.appendChild(option);
                    });
                }
            </script>




            <!-- Submit Button -->
            <div class="flex justify-center mt-8">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 w-full">Save Event</button>
            </div>
        </form>
    </div>
</section>


<script>
    document.getElementById('transaction').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const eventName = selectedOption.getAttribute('data-item');
        const eventBudget = selectedOption.getAttribute('data-budget');

        // Populate the Event Name and Budget fields
        document.getElementById('event_name').value = eventName || '';
        document.getElementById('event_budget').value = eventBudget || '';
    });
</script>
