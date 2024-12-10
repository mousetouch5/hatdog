    <!-- Budget Breakdown Modal -->
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
                    </form>
                </div>
            </div>
        </div>

    </dialog>
    </div>
