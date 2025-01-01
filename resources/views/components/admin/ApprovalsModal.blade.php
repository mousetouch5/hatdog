<div id="approvalsModal" class="fixed inset-0 z-50 hidden">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl">
                <!-- Close button -->
                <button onclick="closeApprovalsModal()"
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl p-3">
                    &times;
                </button>

                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Approval Requests</h2>

                    <!-- Table Container -->
                    <div class="overflow-auto max-h-[60vh]">
                        <table class="w-full text-left border border-gray-200">
                            <thead class="sticky top-0 bg-gray-100">
                                <tr>
                                    <th class="p-2 border-b border-gray-300">Date</th>
                                    <th class="p-2 border-b border-gray-300">Time</th>
                                    <th class="p-2 border-b border-gray-300">Amount</th>
                                    <th class="p-2 border-b border-gray-300">Proof</th>
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
        </div>
    </div>
</div>

<!-- Image Zoom Modal -->
<div id="zoomModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-75"></div>
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full">
                <button onclick="closeZoomModal()"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">
                    &times;
                </button>
                <div class="p-6">
                    <img id="zoomedImage" src="" alt="Zoomed Image"
                        class="w-full h-auto max-h-[80vh] object-contain" />
                </div>
                <div class="px-6 py-3 bg-gray-50 rounded-b-lg flex justify-end">
                    <button onclick="closeZoomModal()"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openApprovalsModal(event) {
        event.preventDefault();
        document.getElementById("approvalsModal").classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling

        fetch('/transactions/unconfirmed')
            .then(response => response.json())
            .then(transactions => {
                const tableBody = document.getElementById('approvalsTableBody');
                tableBody.innerHTML = '';

                if (!transactions || transactions.length === 0) {
                    alert('No transactions to approve. The modal will now close.');
                    closeApprovalsModal();
                    return;
                }

                transactions.forEach(transaction => {
                    const formattedDate = new Date(transaction.date).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    const formattedTime = new Date(transaction.created_at).toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                    const formattedBudget = new Intl.NumberFormat('en-PH', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    }).format(transaction.budget);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td class="p-2 border-b border-gray-300">${formattedDate}</td>
                      <td class="p-2 border-b border-gray-300">${formattedTime}</td>
                        <td class="p-2 border-b border-gray-300">${formattedBudget}</td>
                        <td class="p-2 border-b border-gray-300">
                            ${transaction.reciept 
                                ? `<img src="/storage/${transaction.reciept}" 
                                     alt="Receipt" 
                                     class="w-12 h-12 rounded-full object-cover cursor-pointer hover:opacity-75 transition-opacity" 
                                     onclick="zoomImage('/storage/${transaction.reciept}')">`
                                : 'No Receipt'}
                        </td>
                        <td class="p-2 border-b border-gray-300">${transaction.authorize_official.name}</td>
                        <td class="p-2 border-b border-gray-300">
                            <button onclick="approveTransaction(event, ${transaction.id})" 
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded mr-2">
                                Approve
                            </button>
                            <button onclick="rejectTransaction(event, ${transaction.id})" 
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Reject
                            </button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching transactions:', error);
                closeApprovalsModal();
            });
    }


    function closeApprovalsModal() {
        document.getElementById("approvalsModal").classList.add('hidden');
        document.body.style.overflow = ''; // Restore background scrolling
    }

    function zoomImage(imageSrc) {
        if (imageSrc) {
            document.getElementById("zoomedImage").src = imageSrc;
            document.getElementById("zoomModal").classList.remove('hidden');
        }
    }

    function closeZoomModal() {
        document.getElementById("zoomModal").classList.add('hidden');
    }

    function approveTransaction(event, transactionId) {
        event.preventDefault();
        fetch(`/transactions/${transactionId}/approve`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Transaction approved!');
                    openApprovalsModal(event);
                } else {
                    alert('Failed to approve transaction.');
                }
            })
            .catch(error => console.error('Error approving transaction:', error));
    }

    function rejectTransaction(event, transactionId) {
        event.preventDefault();
        fetch(`/transactions/${transactionId}/reject`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Transaction rejected!');
                    openApprovalsModal(event);
                } else {
                    alert('Failed to reject transaction.');
                }
            })
            .catch(error => console.error('Error rejecting transaction:', error));
    }

    // Close modals when clicking outside
    window.addEventListener('click', (event) => {
        const approvalsModal = document.getElementById('approvalsModal');
        const zoomModal = document.getElementById('zoomModal');

        if (event.target === approvalsModal) {
            closeApprovalsModal();
        }
        if (event.target === zoomModal) {
            closeZoomModal();
        }
    });
</script>
