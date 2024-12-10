<section class="bg-white shadow-lg rounded-lg p-6 flex flex-col">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-semibold mb-6">Add New Event</h2>

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Event Name -->
            <div class="mb-4">
                <label for="event_name" class="block text-sm font-semibold text-gray-700">Event Name:</label>
                <input type="text" id="event_name" name="eventName" placeholder="Enter Event Name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('eventName')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
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

            <!-- Event Date -->
            <div class="mb-4">
                <label for="event_date" class="block text-sm font-semibold text-gray-700">Event Date:</label>
                <input type="date" id="event_date" name="eventDate"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('eventDate')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
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
                    <div class="w-full mr-2">
                        <label for="event_budget" class="block text-sm font-semibold text-gray-700">Event
                            Amount:</label>
                        <input type="text" id="event_budget" name="budget" placeholder="Enter Budget"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <span id="event_budget_error" class="text-red-500 text-xs mt-1 hidden">Error: Budget amount is
                            required.</span>
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
                    <input type="date" name="expense_date[]"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2">
                    <!-- Add expense time -->
                    <input type="time" name="expense_time[]"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2">

                </div>
            </div>

            <button type="button" id="add-expense-button" onclick="addExpense()"
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add More</button>

            <script>
                // Function to handle adding more expense fields
                function addExpense() {
                    const expenseContainer = document.getElementById('expense-container');
                    const newExpenseItem = document.createElement('div');
                    newExpenseItem.className = 'expense-item flex justify-between mt-2';

                    newExpenseItem.innerHTML = `
            <input type='text' name='expenses[]' placeholder='Expense Description'
                class='mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2'>
            <input type='text' name='expense_amount[]' placeholder='Price'
                class='mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2'>
            <input type='date' name='expense_date[]' 
                class='mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2'>
            <input type='time' name='expense_time[]' 
                class='mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 ml-2'>
        `;

                    expenseContainer.appendChild(newExpenseItem);
                }
            </script>



            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Save and
                    Submit</button>
            </div>
        </form>
    </div>
</section>
