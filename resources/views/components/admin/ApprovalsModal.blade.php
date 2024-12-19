<div id="approvalsModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-2xl shadow-lg relative">
        <button onclick="closeApprovalsModal()"
            class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl p-3">
            &times;
        </button>

        <h2 class="text-lg font-semibold text-gray-700 mb-4">Approval Requests</h2>

        <!-- Schedule Table -->
        <div class="overflow-auto max-h-80">
            <table class="w-full text-left border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border-b border-gray-300">Date</th>
                        <th class="p-2 border-b border-gray-300">Time</th>
                        <th class="p-2 border-b border-gray-300">Amount</th>
                        <th class="p-2 border-b border-gray-300">Prooof</th>
                        <th class="p-2 border-b border-gray-300">Initiated</th>
                        <th class="p-2 border-b border-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody id="approvalsTableBody">
                    <!-- Rows will be dynamically loaded here -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="zoomModal" class="modal modal-open hidden">
    <div class="modal-content bg-white rounded-lg shadow-lg w-full max-w-4xl p-6">
        <span class="close absolute top-4 right-4 text-2xl cursor-pointer" onclick="closeZoomModal()">&times;</span>
        <div class="modal-body">
            <img id="zoomedImage" src="" alt="Zoomed Image" class="w-full max-w-4xl" />
        </div>
        <div class="modal-action">
            <button class="btn btn-primary" onclick="closeZoomModal()">Close</button>
        </div>
    </div>
</div>

<style>
    /* CSS to make the modal pop up */
    #approvalsModal {
        display: none;
        /* Hidden by default */
    }

    #approvalsModal.active {
        display: flex;
        /* Shows the modal */
    }
</style>

<script>
    // Open the modal and fetch the list of unconfirmed transactions
    function openApprovalsModal(event) {
        event.preventDefault(); // Prevent default anchor behavior
        const modal = document.getElementById("approvalsModal");
        modal.classList.add("active");

        fetch('/transactions/unconfirmed')
            .then(response => response.json())
            .then(transactions => {
                const tableBody = document.getElementById('approvalsTableBody');
                tableBody.innerHTML = ''; // Clear previous rows

                if (!transactions || transactions.length === 0) {
                    alert('No transactions to approve. The modal will now close.');
                    closeApprovalsModal(); // Close the modal if no transactions are available
                    return; // Exit early to prevent any further processing
                }

                transactions.forEach(transaction => {
                    const row = document.createElement('tr');

                    // Create table data for each column
                    row.innerHTML = `
                <td class="p-2 border-b border-gray-300">${transaction.date}</td>
                <td class="p-2 border-b border-gray-300">${transaction.created_at}</td>
                <td class="p-2 border-b border-gray-300">${transaction.budget}</td>
    <td class="p-2 border-b border-gray-300">
    ${transaction.reciept
        ? `<img src="/storage/${transaction.reciept}" alt="ID Photo" class="id-photo rounded-full" style="width: 50px; height: 50px; object-fit: cover;" onclick="zoomImage('/storage/${transaction.reciept}')">`
        : 'No Reciept'}
</td>

                <td class="p-2 border-b border-gray-300">${transaction.authorize_official.name}</td>
                <td class="p-2 border-b border-gray-300">
                    <button onclick="approveTransaction(event, ${transaction.id})" class="bg-green-500 text-white p-1 rounded">Approve</button>
                    <button onclick="rejectTransaction(event, ${transaction.id})" class="bg-red-500 text-white p-1 rounded">Reject</button>
                </td>
            `;

                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching transactions:', error);
                closeApprovalsModal(); // Close the modal in case of an error
            });
    }

    function closeZoomModal() {
        document.getElementById("zoomModal").classList.add("hidden"); // Hide the zoomed modal
    }
    // Approve the transaction
    function approveTransaction(event, transactionId) {
        event.preventDefault(); // Prevent default behavior when the button is clicked
        fetch(`/transactions/${transactionId}/approve`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content') // If CSRF is required
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Transaction approved!');
                    openApprovalsModal(event); // Refresh the table by reopening the modal
                } else {
                    alert('Failed to approve transaction.');
                }
            })
            .catch(error => console.error('Error approving transaction:', error));
    }

    // Reject the transaction
    function rejectTransaction(event, transactionId) {
        event.preventDefault(); // Prevent default behavior when the button is clicked
        fetch(`/transactions/${transactionId}/reject`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content') // If CSRF is required
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Transaction rejected!');
                    openApprovalsModal(event); // Refresh the table by reopening the modal
                } else {
                    alert('Failed to reject transaction.');
                }
            })
            .catch(error => console.error('Error rejecting transaction:', error));
    }

    // Close the modal
    function closeApprovalsModal() {
        document.getElementById("approvalsModal").classList.remove("active");
    }


    function zoomImage(imageSrc) {
        console.log('Zooming image:', imageSrc); // Debugging line
        const zoomedImage = document.getElementById("zoomedImage");
        if (imageSrc) {
            zoomedImage.src = imageSrc; // Set the source of the zoomed image
            document.getElementById("zoomModal").classList.remove("hidden");
            closeModal1();
            // Show the zoomed image modal
            console.log('Zoom modal should now be visible'); // Debugging line
        } else {
            console.error('No valid image source provided.');
        }
    }
</script>
