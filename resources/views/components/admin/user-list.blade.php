<!-- Modal Structure -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div id="myModal" class="modal modal-open">
    <div class="modal-box w-full max-w-4xl p-6 mt-6">
        <span class="absolute top-4 right-4 text-2xl cursor-pointer" onclick="closeModal()">&times;</span>
        <div class="modal-header">
            <h2 class="text-3xl font-semibold text-gray-800">Pending User Approvals</h2>
        </div>
        <div class="modal-body mt-4">
            <p class="text-gray-600 mb-4">Here you can see all the pending user approvals that need to be processed. You
                can approve or reject them accordingly.</p>
            <!-- Table to display pending user data -->
            <table id="pendingUsersTable" class="table w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">ID Photo</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated via AJAX -->
                </tbody>
            </table>
        </div>
        <div class="modal-action">
            <button class="btn btn-primary" onclick="closeModal()">Close</button>
        </div>
    </div>
</div>

<!-- Zoomed Image Modal -->
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

<script>
    // Ensure the modal is hidden on page load
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("myModal").classList.add("hidden");
        document.getElementById("zoomModal").classList.add("hidden");

    });

    // Open the modal
    function openModal() {
        document.getElementById("myModal").classList.remove("hidden"); // Show the modal
        loadPendingUsers1(); // Load data when the modal opens
    }

    // Close the modal
    function closeModal() {
        document.getElementById("myModal").classList.add("hidden"); // Hide the modal
    }

    // Close the zoomed image modal
    function closeZoomModal() {
        document.getElementById("zoomModal").classList.add("hidden"); // Hide the zoomed modal
    }

    // Function to load pending users data via AJAX
    function loadPendingUsers1() {
        fetch('/pending-approvals') // Ensure this URL matches your route
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#pendingUsersTable tbody');
                tableBody.innerHTML = ''; // Clear any previous data

                data.forEach(user => {
                    const row = document.createElement('tr');
                    row.setAttribute('id', `user-row-${user.id}`); // Set row ID for easy reference
                    row.innerHTML = `
                        <td class="px-4 py-2">${user.name}</td>
                        <td class="px-4 py-2">${user.email}</td>
                        <td class="px-4 py-2">
                            ${user.id_picture_path
                              ? `<img src="${user.id_picture_path}" alt="ID Photo" class="id-photo rounded-full" style="width: 50px; height: 50px; object-fit: cover;" onclick="zoomImage('${user.id_picture_path}')">`
                              : 'No ID Photo'}
                        </td>
                        <td class="px-4 py-2">
                            <button onclick="approveUser(${user.id})" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Approve</button>
                            <button onclick="rejectUser(${user.id})" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Reject</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching pending users:', error));
    }

    // Function to zoom image
    function zoomImage(imageSrc) {
        console.log('Zooming image:', imageSrc); // Debugging line
        const zoomedImage = document.getElementById("zoomedImage");
        if (imageSrc) {
            zoomedImage.src = imageSrc; // Set the source of the zoomed image
            document.getElementById("zoomModal").classList.remove("hidden"); // Show the zoomed image modal
            console.log('Zoom modal should now be visible'); // Debugging line
        } else {
            console.error('No valid image source provided.');
        }
    }



    // Function to approve a user
    function approveUser(userId) {
        fetch(`/approve-user/${userId}`, {
                method: 'POST', // POST request for approving the user
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: userId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the approved user row from the table
                    const row = document.getElementById(`user-row-${userId}`);
                    if (row) row.remove();
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error approving user:', error));
    }

    // Function to reject a user
    function rejectUser(userId) {
        fetch(`/reject-user/${userId}`, {
                method: 'POST', // POST request for rejecting the user
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: userId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the rejected user row from the table
                    const row = document.getElementById(`user-row-${userId}`);
                    if (row) row.remove();
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error rejecting user:', error));
    }
</script>
