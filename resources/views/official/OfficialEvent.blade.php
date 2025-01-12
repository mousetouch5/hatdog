<x-app-layout>


    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <div class="flex h-full min-h-screen">
        <!-- Sidebar -->
        <x-sidebar class="custom-sidebar-class" />
        </aside>
        <!-- end side bar -->



        <!-- grid event section -->
        <div class="flex flex-col lg:flex-row lg:space-x-6">
            <!-- Content Section -->
            <main class="flex-1 px-8 py-6 space-y-6 bg-gray-50">
                <!-- Events Section -->
                <section>
                    <x-recent-events-header2 />

                    <!-- button group -->






















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
                                } elseif ($event->eventStatus === 'upcoming') {
                                    $category = 'upcoming';
                                } else {
                                    $category = 'other'; // Catch-all for unexpected statuses
                                }
                            @endphp

                            <div id="eventCard_{{ $event->id }}" class="bg-white shadow-lg rounded-lg p-4 event-card"
                                data-category="{{ $category }}" {{-- 'recent', 'ongoing', or 'upcoming' --}} data-aos="zoom-in"
                                data-aos-duration="3000"
                                onclick="openEventModal('{{ $event->eventName }}',
                                '{{ $event->id }}',
                               '{{ $event->eventStartDate }}',
                               '{{ $event->eventEndDate }}',
                               '{{ $event->eventStatus }}', 
                                '{{ $event->eventTime }}', 
                                '{{ $event->eventType }}', 
                                 '{{ $event->eventDescription }}', 
                                  '{{ $event->eventLocation }}', 
                                  '{{ $event->organizer }}', 
                                    '{{ asset('storage/' . $event->eventImage) }}',
                                    '{{ $event->budget }}', 
                                    '{{ asset('storage/' . $event->reciept) }}',
                                     {{ $event->expenses->isNotEmpty() ? json_encode($event->expenses) : 'null' }},

            
        )">

                                <img src="{{ asset('storage/' . $event->eventImage) }}" alt="Event"
                                    class="rounded-lg w-full h-48 object-cover">
                                <div>
                                    <h3 class="text-md font-semibold text-left">{{ $event->eventName }}</h3>
                                    <p class="text-sm text-gray-500 text-left">
                                        {{ \Carbon\Carbon::parse($event->eventStartDate)->format('d M Y') }},
                                        {{ \Carbon\Carbon::parse($event->eventTime)->format('h:i A') }},
                                    </p>

                                </div>
                            </div>
                        @endforeach

                        <x-event-modal />
                        <x-budget-breakdown />

                        <!-- Your HTML content here -->


                        <script>
                            // Global object to store the event data
                            let currentEventData = {};

                            // Function to open Event Modal and populate data
                            function openEventModal(eventName, eventId, eventStartDate, eventEndDate, eventStatus, eventTime, eventType,
                                eventDescription, eventLocation, eventOrganizer, eventImage, eventBudget, receiptPath, expenseAmount,
                                expenseDescription) {

                                // Store the event data in the global object
                                currentEventData = {
                                    eventStartDate,
                                    eventEndDate,
                                    eventStatus,
                                    eventId,
                                    eventBudget,
                                    eventName: eventName,
                                    expenseAmount: expenseAmount,
                                    expenseDescription: expenseDescription,
                                    eventTime: eventTime,
                                    eventType: eventType,
                                    eventDescription: eventDescription,
                                    eventLocation: eventLocation,
                                    eventOrganizer: eventOrganizer,
                                    eventImage: eventImage,
                                    receiptPath: receiptPath,
                                };


                                // Update receipt download link
                                const receiptContainer = document.getElementById('receiptContainer');
                                const receiptLink = document.getElementById('receiptDownloadLink');
                                if (receiptPath) {
                                    receiptLink.href = receiptPath; // Set the link to the file
                                    receiptLink.setAttribute('download', 'receipt'); // Force download with a suggested filename
                                    receiptLink.style.display = 'inline'; // Show the link
                                } else {
                                    receiptContainer.style.display = 'none'; // Hide if no receipt
                                }

                                console.log("Current Event Data:", currentEventData);

                                // Store eventStartDate into another variable for splitting
                                const eventDate = eventStartDate;

                                // Format the eventDate to match the input field format (YYYY-MM-DD)
                                const formattedDate = eventDate.split(" ")[0];

                                // Set the formatted date into the input field
                                document.getElementById('eventDate').value = formattedDate;

                                document.getElementById('eventTime').value = eventTime;
                                //  document.getElementById('eventType').value = eventType;
                                document.getElementById('eventDescription').value = eventDescription;
                                document.getElementById('eventLocation').value = eventLocation;
                                document.getElementById('eventOrganizer').value = eventOrganizer;
                                document.getElementById('eventImage').src = eventImage;

                                // Open Modal 1
                                document.getElementById('my_modal_1').showModal();
                                fetchSurveyCounts();
                            }




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
                                    const quantity = parseFloat(expense.quantity_amount) || 1;
                                    const row = document.createElement('tr');

                                    let sum = amount * quantity;
                                    row.innerHTML =
                                        `<td>${description}</td>
                                    <td>₱${amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                   <td>${quantity.toFixed(2)}</td>
                                     <td>₱${sum.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>`;
                                    expenseTableBody.appendChild(row);

                                    // Add to the total expense
                                    totalExpense += amount * quantity;
                                });


                                const markAsDoneBtn = document.getElementById('markAsDoneBtn');
                                const updateButton = document.getElementById('bts');
                                if (eventData.eventStatus === 'done') {
                                    markAsDoneBtn.classList.add('hidden'); // Hide button
                                    updateButton.classList.add('hidden');
                                } else {
                                    markAsDoneBtn.classList.remove('hidden'); // Show button
                                    updateButton.classList.remove('hidden');
                                }


                                // Populate budget summary data
                                document.getElementById('eventName').value = eventData.eventName;
                                document.getElementById('totalBudget').value =
                                    `₱${parseFloat(eventData.eventBudget).toLocaleString('en-PH', { minimumFractionDigits: 2 })}`; // Total budget
                                // document.getElementById('additionalExpenses').value = 0; // Placeholder for additional expenses
                                document.getElementById('totalSpent').value =
                                    `₱${totalExpense.toLocaleString('en-PH', { minimumFractionDigits: 2 })}`; // Example calculation

                                const remainingBudget = parseFloat(eventData.eventBudget) - totalExpense;
                                document.getElementById('remainingBudget').value =
                                    `₱${remainingBudget.toLocaleString('en-PH', { minimumFractionDigits: 2 })}`;

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




                        <!-- Expenses Table -->

            </main>

            <!-- Right-Side Content Section -->
            <aside class="w-full lg:w-1/3 grid grid-cols-1 gap-6 mt-5" data-aos="fade-left" data-aos-duration="2000">
                <x-community-outreach />
                <x-survey-button /> <!-- button here -->
                <x-admin.officials />
            </aside>
        </div>



        <!-- function button for recent, incoming ongoing -->
        <style>
            /* Initially hide all events, we'll toggle visibility using JavaScript */
            .hidden {
                display: none;
            }

            /* Active button style */
            .bg-blue-100 {
                background-color: rgba(205, 243, 255, 1);
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

</x-app-layout>
