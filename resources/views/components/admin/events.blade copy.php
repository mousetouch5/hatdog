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
    // Open the event management modal
    function openEventModal(eventId) {
        document.getElementById("eventId").value = eventId; // Set the event ID
        document.getElementById("eventModal").classList.remove("hidden"); // Show the modal

        fetch(`/events/${eventId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("eventName").value = data.event.name;
                document.getElementById("eventDate").value = data.event.date;
                document.getElementById("eventBudget").value = data.event.budget;
            })
            .catch(error => console.error('Error fetching event data:', error));
    }

    // Close the event management modal
    function closeEventModal() {
        document.getElementById("eventModal").classList.add("hidden");
    }

    // Handle the event form submission to update event details
    document.getElementById('eventForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const eventId = document.getElementById('eventId').value;
        const eventName = document.getElementById('eventName').value;
        const eventDate = document.getElementById('eventDate').value;
        const eventBudget = document.getElementById('eventBudget').value;

        fetch(`/events/${eventId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    name: eventName,
                    date: eventDate,
                    budget: eventBudget
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Event updated successfully!');
                    loadEvents(); // Reload events after update
                    closeEventModal();
                } else {
                    alert('Error updating event');
                }
            })
            .catch(error => console.error('Error updating event:', error));
    });

    // Delete the event
    function deleteEvent() {
        const eventId = document.getElementById('eventId').value;

        fetch(`/events/${eventId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Event deleted successfully!');
                    loadEvents(); // Reload events after deletion
                    closeEventModal();
                } else {
                    alert('Error deleting event');
                }
            })
            .catch(error => console.error('Error deleting event:', error));
    }

    // Load all events to populate the table
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
