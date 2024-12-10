<!-- Modal Structure for Event Management -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Event Management Modal -->
<div id="eventModal" class="modal modal-open">
    <div class="modal-box w-full max-w-4xl p-6 mt-6">
        <span class="absolute top-4 right-4 text-2xl cursor-pointer" onclick="closeEventModal()">&times;</span>
        <div class="modal-header">
            <h2 class="text-3xl font-semibold text-gray-800">Manage Event</h2>
        </div>
        <div class="modal-body mt-4">
            <form id="eventForm">
                <input type="hidden" id="eventId" />

                <div class="mb-4">
                    <label for="eventName" class="block text-gray-700">Event Name:</label>
                    <input type="text" id="eventName" class="w-full px-4 py-2 border rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="eventDate" class="block text-gray-700">Event Date:</label>
                    <input type="date" id="eventDate" class="w-full px-4 py-2 border rounded-md" required />
                </div>

                <div class="mb-4">
                    <label for="eventBudget" class="block text-gray-700">Event Budget:</label>
                    <input type="number" id="eventBudget" class="w-full px-4 py-2 border rounded-md" required />
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Save Changes
                    </button>
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                        onclick="deleteEvent()">
                        Delete Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Event Table -->
<table id="eventTable" class="table-auto w-full mt-4">
    <thead>
        <tr>
            <th class="px-4 py-2">Event Name</th>
            <th class="px-4 py-2">Event Date</th>
            <th class="px-4 py-2">Event Budget</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody id="eventTableBody">
        <!-- Table data will be populated here -->
    </tbody>
</table>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("myModal1").classList.add("hidden");
        document.getElementById("changePasswordModal").classList.add("hidden");
    });

    // Open the modal for managing users
    function openModal1() {
        document.getElementById("myModal1").classList.remove("hidden");
        loadPendingUsers();
    }

    // Close the user management modal
    function closeModal1() {
        document.getElementById("myModal1").classList.add("hidden");
    }

    function loadEvents() {
        fetch('/events')
            .then(response => response.json())
            .then(data => {
                const eventTableBody = document.getElementById('eventTableBody');
                eventTableBody.innerHTML = ''; // Clear existing rows
                data.events.forEach(event => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-2">${event.name}</td>
                        <td class="px-4 py-2">${event.date}</td>
                        <td class="px-4 py-2">${event.budget}</td>
                        <td class="px-4 py-2">
                            <button onclick="openEventModal(${event.id})" class="bg-blue-500 text-white px-4 py-2 rounded-md">Edit</button>
                            <button onclick="deleteEvent(${event.id})" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
                        </td>
                    `;
                    eventTableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error loading events:', error));
    }

    // Load events on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadEvents();
    });
</script>
