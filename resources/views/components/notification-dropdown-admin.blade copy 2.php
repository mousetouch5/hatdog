<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<div class="relative">
    <button class="relative" id="notification-button" onclick="toggleNotificationDropdown()">
        <span class="material-symbols-outlined">notifications</span>
        <!-- Badge for unread notifications -->
        <span
            class="absolute top-0 right-0 inline-flex items-center justify-center w-3 h-3 bg-blue-500 text-white text-xs font-bold rounded-full hidden"
            id="notification-badge"></span>
    </button>

    <!-- Notification Dropdown -->
    <div id="notification-dropdown"
        class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-300 rounded-lg shadow-lg">
        <div class="p-4">
            <h3 class="text-gray-700 font-semibold text-sm mb-2">Notifications</h3>
            <div id="notification-list">
                <!-- Notifications will be dynamically loaded here -->
            </div>
            <!-- See all notifications -->
            <div class="text-center mt-2">
                <a href="#" class="text-blue-500 hover:underline text-sm">See all notifications</a>
            </div>
        </div>
    </div>
</div>

@include('components.admin.ApprovalsModal')










<script>
    // Function to toggle the notification dropdown
    function toggleNotificationDropdown() {
        const dropdown = document.getElementById('notification-dropdown');
        dropdown.classList.toggle('hidden');

        if (!dropdown.classList.contains('hidden')) {
            fetchNotifications(); // Fetch notifications when dropdown is opened
        } else {
            resetNotificationBadge(); // Reset badge count when dropdown closes
        }
    }

    // Function to fetch notifications and unconfirmed approvals
    function fetchNotifications() {
        Promise.all([
                // Fetching unconfirmed schedule count and details
                fetch('/schedules/unconfirmed/count').then(response => response.json())
            ])
            .then(([unconfirmedData]) => {
                const notificationList = document.getElementById('notification-list');
                const notificationBadge = document.getElementById('notification-badge');
                notificationList.innerHTML = ''; // Clear existing notifications

                // Update notification badge
                if (unconfirmedData.unconfirmed_count > 0) {
                    notificationBadge.classList.remove('hidden');
                    notificationBadge.textContent = unconfirmedData.unconfirmed_count;
                    notificationBadge.classList.add('ping');
                } else {
                    notificationBadge.classList.add('hidden');
                    notificationBadge.classList.remove('ping');
                    notificationBadge.textContent = '';
                }

                // Display unconfirmed transactions as notifications
                if (unconfirmedData.created_at && unconfirmedData.created_at.length > 0) {
                    unconfirmedData.created_at.forEach(createdAt => {
                        const notificationItem = document.createElement('div');
                        notificationItem.className = 'border-b border-gray-300 py-2';
                        notificationItem.innerHTML = `
                    <p class="text-sm text-gray-600">Unconfirmed Transactions created at: ${createdAt}</p>
                `;
                        notificationList.appendChild(notificationItem);
                    });
                }

                // Display "See Approvals" link if there are unconfirmed approvals
                if (unconfirmedData.unconfirmed_count > 0) {
                    const approvalsLink = document.createElement('div');
                    approvalsLink.className = 'border-b border-gray-300 py-2';
                    approvalsLink.innerHTML = `
                <p class="text-sm text-purple-600" onclick="openApprovalsModal(event)">See Approvals</p>
            `;
                    notificationList.appendChild(approvalsLink);
                }

                // Show fallback message if no notifications and unconfirmed approvals
                if ((!unconfirmedData.created_at || unconfirmedData.created_at.length === 0) && unconfirmedData
                    .unconfirmed_count === 0) {
                    notificationList.innerHTML = '<p class="text-sm text-gray-600">No new notifications.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
                const notificationList = document.getElementById('notification-list');
                notificationList.innerHTML =
                    '<p class="text-sm text-red-500">Failed to load notifications. Please try again later.</p>';
            });
    }

    // Function to reset the notification badge
    function resetNotificationBadge() {
        const notificationBadge = document.getElementById('notification-badge');
        notificationBadge.classList.add('hidden');
        notificationBadge.textContent = '';
        notificationBadge.classList.remove('ping');
    }

    // Close dropdown when clicking outside
    window.onclick = function(event) {
        const dropdown = document.getElementById('notification-dropdown');
        const button = document.getElementById('notification-button');

        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
            resetNotificationBadge();
        }
    };

    // Poll for notifications every 10 seconds
    setInterval(fetchNotifications, 10000);
</script>





<style>
    @keyframes ping {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        75% {

            transform: scale(1.2);
            opacity: 0.75;
        }

        100% {
            transform: scale(1);
            opacity: 0;
        }
    }

    .ping {
        animation: ping 1s infinite;
    }

</style>
