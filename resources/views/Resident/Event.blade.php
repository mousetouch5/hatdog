<x-app-layout>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>


    <div class="flex h-full min-h-screen">
        <!-- Sidebar -->
        <aside class="w-full bg-gray-100 shadow-lg">
            <div class="px-6">
                <!-- <div class="text-lg font-semibold">Liquidation Loom</div> -->
            </div>
            <div class="flex h-full min-h-screen">
                <!-- Sidebar -->
                <x-resident.resident-side-bar />
                <!-- end side bar -->


















                <!-- grid event section -->
                <div class="flex flex-col lg:flex-row lg:space-x-6">
                    <!-- Content Section -->
                    <main class="flex-1 px-8 py-6 space-y-6 bg-gray-50">

                        <section>
                            <x-recent-events-header />
































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
                                            $category = 'upcoming';
                                        } else {
                                            $category = 'other'; // Catch-all for unexpected statuses
                                        }
                                    @endphp

                                    <div id="eventCard_{{ $event->id }}"
                                        class="bg-white shadow-lg rounded-lg p-4 event-card"
                                        data-category="{{ $category }}" {{-- 'recent', 'ongoing', or 'upcoming' --}} data-aos="zoom-in"
                                        data-aos-duration="3000"
                                        onclick="openEventModal('{{ $event->eventName }}',
                                        '{{ $event->userId }}',
                                        '{{ $event->id }}',
                                        '{{ $event->eventEndDate }}', 
                                        '{{ $event->eventTime }}', 
                                        '{{ $event->eventType }}', 
                                        '{{ $event->eventDescription }}', 
                                        '{{ $event->eventLocation }}', 
                                        '{{ $event->organizer }}', 
                                        '{{ asset('storage/' . $event->eventImage) }}',
                                        '{{ $event->budget }}', 
                                        {{ $event->expenses->isNotEmpty() ? json_encode($event->expenses) : 'null' }},)">
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



                                <x-event-modal2 />
                                <x-budget-breakdown-modal />







                                <script>
                                    // Global object to store the event data
                                    let currentEventData = {};

                                    // Function to open Event Modal and populate data
                                    function openEventModal(eventName, userId, eventId, eventDate, eventTime, eventType, eventDescription,
                                        eventLocation,
                                        eventOrganizer,
                                        eventImage, eventBudget, expenseAmount, expenseDescription) {
                                        // Store the event data in the global object
                                        currentEventData = {
                                            userId,
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
                                        console.log(eventId);
                                        console.log("User: " + userId);
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
                                    }

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
                                        const remainingBudget = parseFloat(eventData.eventBudget) - totalExpense;
                                        document.getElementById('remainingBudget').value = remainingBudget.toFixed(2);
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

                                <!-- button group recent , incoming , upcoming  javascript function -->


                                <script>
                                    // JavaScript to handle the event category toggle
                                    document.addEventListener("DOMContentLoaded", function() {
                                        const buttons = document.querySelectorAll("button");
                                        const eventCards = document.querySelectorAll(".event-card");

                                        // Function to filter event cards based on category
                                        function filterEvents(category) {
                                            eventCards.forEach(card => {
                                                if (category === "all" || card.getAttribute("data-category") === category) {
                                                    card.classList.remove("hidden");
                                                } else {
                                                    card.classList.add("hidden");
                                                }
                                            });
                                        }

                                        // Event listener for button clicks
                                        buttons.forEach(button => {
                                            button.addEventListener("click", () => {
                                                // Reset all buttons' styles
                                                buttons.forEach(btn => btn.classList.remove("bg-blue-100"));
                                                button.classList.add("bg-blue-100");

                                                // Determine which category to filter by
                                                if (button.id === "recent-events") {
                                                    filterEvents("recent");
                                                } else if (button.id === "ongoing-events") {
                                                    filterEvents("ongoing");
                                                } else if (button.id === "upcoming-events") {
                                                    filterEvents("upcoming");
                                                }
                                            });
                                        });

                                        // Initial load, show all events
                                        filterEvents("all");
                                    });
                                </script>


                                <!-- Expenses Table Section -->
                        </section>
                    </main>
























                    <!-- Right-Side Content Section -->
                    <aside class="w-full lg:w-1/3 grid grid-cols-1 gap-6 mt-5" data-aos="fade-left"
                        data-aos-duration="2000">
                        <!-- Barangay Officials -->



                        <x-admin.officials />





                        <x-community-outreach />

















                        <!--survey boss -->
                        <!-- Button to Open the Modal Survey -->
                        <button class="btn bg-cyan-500 w-full mt-5" onclick="Survey.showModal()">Answer
                            Survey</button>
                        <x-survey />
                    </aside>
                </div>
        </aside>
    </div>




    <!-- JavaScript for Modal Survey -->
    <script>
        const my_modal_4 = document.getElementById("Survey");

        // Show the modal
        document.querySelector("[onclick='my_modal_4.showModal()']").addEventListener("click", function() {
            Survey.showModal();
        });

        // Close the modal when the close button is clicked
        document.querySelector("form[method='dialog']").addEventListener("submit", function() {
            Survey.close();
        });
    </script>

</x-app-layout>
