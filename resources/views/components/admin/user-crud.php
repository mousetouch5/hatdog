<!-- Modal Structure -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="myModal1" class="modal modal-open">
    <div class="modal-box w-full max-w-4xl p-6 mt-6">
        <span class="absolute top-4 right-4 text-2xl cursor-pointer" onclick="closeModal1()">&times;</span>
        <div class="modal-header">
            <h2 class="text-3xl font-semibold text-gray-800 py-9">Verified Users Control</h2>
        </div>
        <div class="modal-body mt-4">
            <p class="text-gray-600 mb-4">Here you can see all the pending user approvals that need to be processed. You can change password or delete them accordingly.</p>
            
            <!-- Search Input -->
            <input type="text" id="searchInput" placeholder="Search by name or email" class="w-full px-4 py-2 mb-4 border rounded-md" oninput="loadPendingUsers()" />

            <!-- Table to display pending user data -->
            <table id="pendingUsersTable1" class="table w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">ID Photo</th>
                        <th class="px-4 py-2">Comittee</th>
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
            <button class="btn btn-primary" onclick="closeModal1()">Close</button>
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








<!-- Password Change Modal -->
<div id="changePasswordModal" class="modal modal-open hidden">
    <div class="modal-box w-full max-w-lg p-6 mt-6">
        <span class="absolute top-4 right-4 text-2xl cursor-pointer" onclick="closeChangePasswordModal()">&times;</span>
        <div class="modal-header">
            <h2 class="text-3xl font-semibold text-gray-800">Change User Password</h2>
        </div>
        <div class="modal-body mt-4">
            <p class="text-gray-600 mb-4">Enter the new password for the selected user.</p>
            <form id="changePasswordForm">
                <input type="hidden" id="userIdForPasswordChange" />
                <div class="mb-4">
                    <label for="newPassword" class="block text-gray-700">New Password:</label>
                    <input type="password" id="newPassword" class="w-full px-4 py-2 border rounded-md" required />
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Ensure the modal is hidden on page load
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("myModal1").classList.add("hidden");
        document.getElementById("changePasswordModal").classList.add("hidden");
        document.getElementById("zoomModal").classList.add("hidden");
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

    // Open the password change modal
    function openChangePasswordModal(userId) {
        document.getElementById("userIdForPasswordChange").value = userId; // Set the userId for password change
        document.getElementById("changePasswordModal").classList.remove("hidden"); // Show the modal
    }

    // Close the password change modal
    function closeChangePasswordModal() {
        document.getElementById("changePasswordModal").classList.add("hidden");
    }

        function closeZoomModal() {
        document.getElementById("zoomModal").classList.add("hidden"); // Hide the zoomed modal
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


// Load pending users via AJAX, with search and pagination
function loadPendingUsers(page = 1) {
    const searchQuery = document.getElementById('searchInput').value;

    fetch(`/users?page=${page}&search=${searchQuery}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#pendingUsersTable1 tbody');
            const pagination = document.getElementById('pagination');
            
            tableBody.innerHTML = ''; // Clear existing rows
            pagination.innerHTML = ''; // Clear pagination links
            
            // Populate table rows with user data
            data.data.forEach(user => {
                const row = document.createElement('tr');
                row.setAttribute('id', `user-row-${user.id}`);
                row.innerHTML = `
                    <td class="px-4 py-2 text-xs">${user.name}</td>
                    <td class="px-4 py-2 text-xs">${user.email}</td>
                    <td class="px-4 py-2 text-xs">
                            ${user.id_picture_path
                              ? `<img src="${user.id_picture_path}" alt="ID Photo" class="id-photo rounded-full" style="width: 50px; height: 50px; object-fit: cover;" onclick="zoomImage('${user.id_picture_path}')">`
                              : 'No ID Photo'}
                        </td>
                    <td class="px-4 py-2 text-xs">${user.comittee}</td>
                    <td class="px-4 py-2">
                    <div class="flex gap-2">
                    <button onclick="openChangePasswordModal(${user.id})" class="bg-blue-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-blue-600">Change Password</button>
                    <button onclick="deleteUser(${user.id})" class="bg-red-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-red-600">Delete</button>
                    <button onclick="updateUser(${user.id})" class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600">Update</button>
                    <button id="block-unblock-btn-${user.id}" onclick="toggleBlock(${user.id}, this)" class="bg-yellow-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-yellow-600">
                        ${user.is_blocked ? 'Unblock' : 'Block'}
                    </button>
                </div>

        </td>
                `;
                tableBody.appendChild(row);
            });

            // Render pagination links
            if (data.last_page > 1) {
                for (let i = 1; i <= data.last_page; i++) {
                    const pageLink = document.createElement('a');
                    pageLink.href = 'javascript:void(0)';
                    pageLink.textContent = i;
                    pageLink.classList.add('px-3', 'py-2', 'border', 'border-gray-300', 'hover:bg-gray-200');
                    pageLink.onclick = () => loadPendingUsers(i); // Load the clicked page
                    pagination.appendChild(pageLink);
                }
            }
        })
        .catch(error => console.error('Error fetching pending users:', error));
}

    // Submit the new password form
    document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const userId = document.getElementById('userIdForPasswordChange').value;
        const newPassword = document.getElementById('newPassword').value;

        fetch(`/change-password/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ newPassword: newPassword })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeChangePasswordModal(); // Close the modal on success
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error changing password:', error));
    });

    // Function to delete a user
    function deleteUser(userId) {
        fetch(`/delete-user/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ id: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById(`user-row-${userId}`);
                if (row) row.remove();
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error deleting user:', error));
    }

        function updateUser(userId) {
        fetch(`/updates-user/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ id: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {

                alert(data.message);
            }
        })
        .catch(error => console.error('Error Updating user:', error));
    }




    // block - unblock 

    function toggleBlock(userId, button) {
    const isBlocked = button.textContent.trim() === 'Unblock';
    const action = isBlocked ? 'unblock' : 'block'; // Determine action dynamically
    const url = `/users/${action}/${userId}`; // Use the correct endpoint

    // Send a POST request to block/unblock user
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                // Toggle button text and style
                if (isBlocked) {
                    button.textContent = 'Block';
                    button.classList.remove('bg-green-500', 'hover:bg-green-600');
                    button.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
                } else {
                    button.textContent = 'Unblock';
                    button.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
                    button.classList.add('bg-green-500', 'hover:bg-green-600');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing the request.');
        });
}


</script>
