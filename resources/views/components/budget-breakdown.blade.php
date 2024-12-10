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

                <div class="modal-action">
                    <form method="dialog">
                        <button class="btn">Close</button>
                        <button id="markAsDoneBtn" class="btn btn-success hidden" onclick="markEventAsDone()">
                            Mark as Done
                        </button>
                    </form>
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
