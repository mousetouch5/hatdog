<x-app-layout>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <div class="flex h-full min-h-screen">
        <x-sidebar class="custom-sidebar-class" />

        <!-- end side bar -->

        <!-- grid event section -->

        <div class="flex flex-col lg:flex-row lg:space-x-6">
            <!-- Content Section -->
            <main class="flex-1 px-8 py-6 space-y-6 bg-gray-50">
                <!-- Events Section -->
                <section>
                    <x-recent-events-header />




                    <!-- GRID SECTION OF EVENT CARDS -->
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        <!-- Event Card with modal function -->
                        @foreach ($events as $event)
                            @php
                                // Explicitly define category based on eventStatus
                                if ($event->eventStatus === 'done') {
                                    $category = 'recent';
                                } elseif ($event->eventStatus === 'ongoing') {
                                    $category = 'ongoing';
                                } elseif ($event->eventStatus === 'ongoing') {
                                    $category = 'ongoing';
                                } else {
                                    $category = 'other'; // Catch-all for unexpected statuses
                                }
                            @endphp

                            <div id="eventCard_{{ $event->id }}" class="bg-white shadow-lg rounded-lg p-4 event-card"
                                data-category="{{ $category }}" {{-- 'recent', 'ongoing', or 'upcoming' --}} data-aos="zoom-in"
                                data-aos-duration="3000"
                                onclick="openEventModal('{{ $event->eventName }}',
                                '{{ $event->id }}',
                               '{{ $event->eventDate }}', 
                                '{{ $event->eventTime }}', 
                                '{{ $event->eventType }}', 
                                 '{{ $event->eventDescription }}', 
                                  '{{ $event->eventLocation }}', 
                                  '{{ $event->organizer }}', 
                                         '{{ asset('storage/' . $event->eventImage) }}',
                                             '{{ $event->budget }}', 
                                     {{ $event->expenses->isNotEmpty() ? json_encode($event->expenses) : 'null' }},

            
                                    )">

                                <img src="{{ asset('storage/' . $event->eventImage) }}" alt="Event"
                                    class="rounded-lg w-full h-48 object-cover">
                                <div>
                                    <h3 class="text-md font-semibold text-left">{{ $event->eventName }}</h3>
                                    <p class="text-sm text-gray-500 text-left">
                                        {{ \Carbon\Carbon::parse($event->eventDate)->format('d M Y') }},
                                        {{ \Carbon\Carbon::parse($event->eventTime)->format('h:i A') }},
                                    </p>

                                </div>
                            </div>
                        @endforeach

                        <x-event-modal />
                        <x-budget-breakdown-modal />





                        <script>
                            // Global object to store the event data
                            let currentEventData = {};

                            // Function to open Event Modal and populate data
                            function openEventModal(eventName, eventId, eventDate, eventTime, eventType, eventDescription, eventLocation,
                                eventOrganizer,
                                eventImage, eventBudget, expenseAmount, expenseDescription) {
                                // Store the event data in the global object
                                currentEventData = {
                                    eventId,
                                    eventBudget,
                                    eventBudget,
                                    eventName: eventName,
                                    expenseAmount: expenseAmount,
                                    expenseDescription: expenseDescription,
                                    eventDate: eventDate,
                                    eventTime: eventTime,
                                    eventType: eventType,
                                    eventDescription: eventDescription,
                                    eventLocation: eventLocation,
                                    eventOrganizer: eventOrganizer,
                                    eventImage: eventImage,
                                };

                                console.log("Current Event Data:", currentEventData);

                                // Populate Modal 1 fields with event data
                                // Format the eventDate to match the input field format (YYYY-MM-DD)
                                const formattedDate = eventDate.split(" ")[0];

                                // Set the formatted date into the input field
                                document.getElementById('eventDate').value = formattedDate;

                                document.getElementById('eventTime').value = eventTime;
                                document.getElementById('eventType').value = eventType;
                                document.getElementById('eventDescription').value = eventDescription;
                                document.getElementById('eventLocation').value = eventLocation;
                                document.getElementById('eventOrganizer').value = eventOrganizer;
                                document.getElementById('eventImage').src = eventImage;

                                // Open Modal 1
                                document.getElementById('my_modal_1').showModal();
                                fetchSurveyCounts();
                            }


                            // Function to Fetch Survey Counts
                            function fetchSurveyCounts() {
                                const eventId = currentEventData.eventId;

                                if (!eventId) {
                                    console.error("Event ID is missing!");
                                    return;
                                }

                                $.ajax({
                                    url: '/survey-count',
                                    method: 'GET',
                                    data: {
                                        event_id: eventId
                                    },
                                    success: function(response) {
                                        console.log("Survey Counts:", response);
                                        $('#likeCount').text(response.likeCount);
                                        $('#unlikeCount').text(response.unlikeCount);
                                        $('#surveyCount').text(response.totalCount);
                                    },
                                    error: function() {
                                        alert('Failed to fetch survey counts. Please try again.');
                                    }
                                });
                            }

                            // Close Modal on Outside Click
                            document.addEventListener('DOMContentLoaded', function() {
                                const modal = document.getElementById('my_modal_1');
                                const budgetModal = document.getElementById('budgetModal');

                                [modal, budgetModal].forEach(modalElement => {
                                    modalElement.addEventListener('click', (e) => {
                                        if (e.target === modalElement) {
                                            modalElement.close();
                                        }
                                    });
                                });
                            });



                            // Function to open Budget Modal and populate data
                            // Function to open Budget Modal and populate data
                            function openBudgetModal() {
                                const eventData = currentEventData;

                                // Check if expenseAmount is an array or a single value
                                let expenses = Array.isArray(eventData.expenseAmount) ? eventData.expenseAmount : [eventData.expenseAmount];

                                const expenseTableBody = document.getElementById('expenseTableBody');
                                expenseTableBody.innerHTML = ''; // Clear any previous rows

                                let totalExpense = 0; // Initialize total expenses

                                // Populate table rows and calculate total expenses
                                expenses.forEach((expense) => {
                                    const amount = parseFloat(expense.expense_amount) || 0;
                                    const description = expense.expense_description || 'No Description';

                                    const row = document.createElement('tr');
                                    row.innerHTML = `<td>${description}</td><td>${amount.toFixed(2)}</td>`;
                                    expenseTableBody.appendChild(row);

                                    // Add to the total expense
                                    totalExpense += amount;
                                });

                                // Populate budget summary data
                                document.getElementById('eventName').value = eventData.eventName;
                                document.getElementById('totalBudget').value = eventData.eventBudget; // Total budget
                                //  document.getElementById('additionalExpenses').value = 0; // Placeholder for additional expenses
                                document.getElementById('totalSpent').value = totalExpense.toFixed(2); // Example calculation

                                // Open Modal 2
                                document.getElementById('budgetModal').showModal();
                            }


                            // Close modals when clicking outside
                            document.addEventListener('DOMContentLoaded', function() {
                                const modal = document.getElementById('my_modal_1');
                                const budgetModal = document.getElementById('budgetModal');

                                [modal, budgetModal].forEach(modalElement => {
                                    modalElement.addEventListener('click', (e) => {
                                        if (e.target === modalElement) {
                                            modalElement.close();
                                        }
                                    });
                                });
                            });
                        </script>


            </main>
            <!-- Right-Side Content Section -->
            <aside class="w-full lg:w-1/3 grid grid-cols-1 gap-6 mt-5" data-aos="fade-right" data-aos-duration="2000">
                <x-community-outreach />
                <!-- Barangay Officials -->
                <x-survey-button />
                <x-admin.officials />
            </aside>
        </div>

        <script>
            AOS.init();
        </script>
</x-app-layout>
