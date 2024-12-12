<!-- Modal Structure -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="myModal2" class="modal modal-open">
    <div class="modal-box w-full max-w-4xl p-6 mt-6">
        <span class="absolute top-4 right-4 text-2xl cursor-pointer" onclick="closeModal2()">&times;</span>
        <div class="modal-header">
            <h2 class="text-3xl font-semibold text-gray-800">Activities</h2>
        </div>
        <div class="modal-body mt-4">
            <p class="text-gray-600 mb-4">Here you can see all activities.</p>

            <!-- Search Input -->
            <input type="text" id="searchEvent" placeholder="Search by name"
                class="w-full px-4 py-2 mb-4 border rounded-md" oninput="loadPendingEvents()" />

            <!-- Table to display pending user data -->
            <table id="pendingEventsTable" class="table w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Activities</th>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated via AJAX -->
                </tbody>
            </table>

            <!-- Pagination -->
            <div id="pagination" class="mt-4">
                <!-- Pagination links will be populated here -->
            </div>
        </div>
        <div class="modal-action">
            <button class="btn btn-primary" onclick="closeModal2()">Close</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("myModal2").classList.add("hidden");

    });

    function openModal2() {
        document.getElementById("myModal2").classList.remove("hidden");
        loadPendingEvents();
    }

    // Close the user management modal
    function closeModal2() {
        document.getElementById("myModal2").classList.add("hidden");
    }
</script>


<script>
    // Load all events into the modal
    function loadPendingEvents(search = "") {
        fetch(`/events/load?search=${search}`, {
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector("#pendingEventsTable tbody");
                tbody.innerHTML = ""; // Clear the table

                // Populate table rows
                if (data.data.length > 0) {
                    data.data.forEach(event => {
                        console.log(event.eventImage);
                        const row = `
                        <tr>
                            <td class="px-4 py-2">${event.eventName}</td>
                            <td class="px-4 py-2">
                                <img src="${event.eventImage}" alt="Image" class="w-16 h-16 rounded">    
                                </td>

                            <td class="px-4 py-2">
                                <button class="btn btn-sm btn-success" onclick="viewEvent(${event.id})">View</button>
                            </td>
                        </tr>
                    `;
                        tbody.innerHTML += row;
                    });
                } else {
                    tbody.innerHTML = `<tr><td colspan="3" class="text-center py-4">No events found.</td></tr>`;
                }
                // Handle pagination
                const pagination = document.getElementById("pagination");
                pagination.innerHTML = data.links; // Laravel pagination links
            })
            .catch(error => console.error("Error loading events:", error));
    }
    // Handle search input
    document.getElementById("searchEvent").addEventListener("input", function() {
        const searchValue = this.value;
        loadPendingUsers(searchValue);
    });
</script>


<div id="changeEventModal" class="modal modal-open hidden">
    <div class="modal-box w-full max-w-lg p-6 mt-6">
        <span class="absolute top-4 right-4 text-2xl cursor-pointer" onclick="closeChangePasswordModal()">&times;</span>
        <div class="modal-header">
            <h2 class="text-3xl font-semibold text-gray-800">Change Activity </h2>
        </div>
        <div class="modal-body mt-4">
            <p class="text-gray-600 mb-4">Enter new details.</p>
            <form id="changeActivity">

                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Submit</button>
            </form>
        </div>
    </div>
</div>
