<div id="addModal2" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-11/12 md:w-3/4 lg:w-1/2 max-h-[80vh] overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Transactions</h2>
        <!-- Search Input -->
        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Search transactions..."
                class="w-full p-2 border border-gray-300 rounded">
        </div>
        <table class="w-full table-auto" id="transactions-table2">
            <thead>
                <tr class="bg-gray-200 text-gray-600 text-left text-sm font-semibold">
                    <th class="py-3 px-4">Authorized Official</th>
                    <th class="py-3 px-4">Item</th>
                    <th class="py-3 px-4">Date</th>
                    <th class="py-3 px-4">Budget Given</th>
                    <th class="py-3 px-4">Received By</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic content goes here -->
            </tbody>
        </table>
        <div class="mt-4">
            <button id="closeModal" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Close</button>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function toggleModal2() {
        $('#addModal2').toggleClass('hidden'); // Toggle the hidden class to show/hide the modal
    }
    $(document).ready(function() {
        // Function to fetch transactions and display them in the modal
        function fetchTransactions(query = '') {
            $.ajax({
                url: '{{ route('api.transactions2') }}', // Replace with your actual route if needed
                method: 'GET',
                data: {
                    search: query // Pass the search query
                },
                success: function(data) {
                    let tableBody = $('#transactions-table2 tbody');
                    tableBody.empty(); // Clear the existing rows

                    // Loop through the data and append new rows
                    data.forEach(function(trs) {
                        let authorizedOfficial = trs.authorize_official ? trs
                            .authorize_official.name : 'No official assigned';
                        let receivedBy = trs.recieve_by ? trs.recieve_by.name : 'Unknown';
                        let status = trs.is_approved ? 'Confirmed' : 'Not Confirmed';
                        let printUrl = `/transactions/${trs.id}/print`;
                        let downloadUrl = `/transactions/${trs.id}/download`;

                        // Constructing the table row with transaction data
                        let row = `
                        <tr class="odd:bg-gray-50">
                            <td class="py-3 px-4">${authorizedOfficial}</td>
                            <td class="py-3 px-4">${trs.description}</td>
                            <td class="py-3 px-4">${new Date(trs.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long' })}</td>
                            <td class="py-3 px-4 text-green-500">${trs.budget}</td>
                            <td class="py-3 px-4">${receivedBy}</td>
                            <td class="py-3 px-4">${status}</td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="${printUrl}" target="_blank" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                    Print
                                </a>
                                <a href="${downloadUrl}" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                                    Download
                                </a>
                            </td>
                        </tr>
                    `;
                        tableBody.append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching transactions:', error);
                }
            });
        }

        // Initial call to fetch data
        fetchTransactions();

        // Call fetchTransactions every second (1000ms) to keep data updated
        setInterval(fetchTransactions, 1000);

        // Close modal when the "Close" button is clicked
        $('#closeModal').click(function() {
            $('#addModal2').addClass('hidden'); // Hide the modal
        });

        // Handle search input
        $('#searchInput').on('keyup', function() {
            let searchQuery = $(this).val(); // Get the search query
            fetchTransactions(searchQuery); // Call fetchTransactions with the search query
        });
    });
</script>
