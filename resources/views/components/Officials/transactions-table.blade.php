<table class="w-full table-auto" id="transactions-table">
    <thead>
        <tr class="bg-gray-200 text-gray-600 text-left text-sm font-semibold">
            <th class="py-3 px-4">Authorized Official</th>
            <th class="py-3 px-4">Item</th>
            <th class="py-3 px-4">Date</th>
            <th class="py-3 px-4">Budget Given</th>
            <th class="py-3 px-4">Received By</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4">Action</th>
            <th class="py-3 px-4">Archive</th>
        </tr>
    </thead>
    <tbody>
        <!-- Dynamic content goes here -->
    </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchTransactions() {
            $.ajax({
                url: '{{ route('api.transactions') }}',
                method: 'GET',
                success: function(data) {
                    let tableBody = $('#transactions-table tbody');
                    tableBody.empty(); // Clear the existing rows

                    // Loop through the data and append new rows
                    data.forEach(function(trs) {
                        let authorizedOfficial = trs.authorize_official ? trs
                            .authorize_official.name : 'No official assigned';
                        let receivedBy = trs.recieve_by ? trs.recieve_by.name : 'Unknown';
                        let status = trs.is_approved ? 'Confirmed' : 'Not Confirmed';
                        let printUrl = `/transactions/${trs.id}/print`;
                        let downloadUrl = `/transactions/${trs.id}/download`;

                        const formattedBudget = new Intl.NumberFormat('en-PH', {
                            style: 'currency',
                            currency: 'PHP',
                            minimumFractionDigits: 2
                        }).format(trs.budget);


                        // Constructing the table row with transaction data
                        let row = `
                    <tr class="odd:bg-gray-50">
                        <td class="py-3 px-4">${authorizedOfficial}</td>
                        <td class="py-3 px-4">${trs.description}</td>
                        <td class="py-3 px-4">${new Date(trs.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long' })}</td>
                        <td class="py-3 px-4 text-green-500">${formattedBudget}</td>
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
                        <td class="py-3 px-4">
                            <form action="/transactions/${trs.id}/archive" method="POST" onsubmit="return confirm('Are you sure you want to archive this transaction?');">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-blue-600 focus:outline-none" title="Archive">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </form>
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

        // Call fetchTransactions every second (1000ms)
        setInterval(fetchTransactions, 1000);
    });
</script>
