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
                <aside class="w-1/4 bg-gray-100 shadow-lg h-[100vh] sticky top-1">

                    <nav class="mt-4">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center px-6 py-3 text-gray-600 hover:bg-blue-100">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.6818 6.22623L4.00032 14.362V23.1428C4.00032 23.3701 4.07055 23.5882 4.19556 23.7489C4.32058 23.9097 4.49013 24 4.66693 24L9.33574 23.9845C9.51196 23.9833 9.68066 23.8925 9.80495 23.7319C9.92925 23.5712 9.99902 23.3539 9.99902 23.1272V17.9993C9.99902 17.772 10.0693 17.5539 10.1943 17.3932C10.3193 17.2324 10.4888 17.1421 10.6656 17.1421H13.3321C13.5089 17.1421 13.6784 17.2324 13.8035 17.3932C13.9285 17.5539 13.9987 17.772 13.9987 17.9993V23.1235C13.9984 23.2363 14.0155 23.348 14.0489 23.4524C14.0822 23.5567 14.1313 23.6515 14.1932 23.7314C14.2551 23.8113 14.3287 23.8747 14.4097 23.9179C14.4908 23.9611 14.5776 23.9834 14.6653 23.9834L19.3325 24C19.5093 24 19.6788 23.9097 19.8038 23.7489C19.9289 23.5882 19.9991 23.3701 19.9991 23.1428V14.3561L12.3193 6.22623C12.229 6.13265 12.1165 6.08161 12.0005 6.08161C11.8846 6.08161 11.7721 6.13265 11.6818 6.22623ZM23.8155 11.756L20.3324 8.06394V0.642929C20.3324 0.472414 20.2797 0.308882 20.186 0.18831C20.0922 0.0677371 19.965 0 19.8324 0H17.4993C17.3667 0 17.2395 0.0677371 17.1457 0.18831C17.052 0.308882 16.9993 0.472414 16.9993 0.642929V4.53319L13.2692 0.586673C12.9112 0.207869 12.462 0.000757234 11.9984 0.000757234C11.5349 0.000757234 11.0857 0.207869 10.7277 0.586673L0.181444 11.756C0.130818 11.8098 0.0889323 11.8759 0.0581813 11.9505C0.0274303 12.0251 0.00841634 12.1068 0.00222573 12.1909C-0.00396488 12.275 0.00278923 12.3598 0.0221021 12.4406C0.041415 12.5213 0.0729083 12.5963 0.114782 12.6614L1.1772 14.3223C1.21896 14.3876 1.27033 14.4417 1.32835 14.4814C1.38638 14.5212 1.44994 14.5458 1.51538 14.5539C1.58082 14.562 1.64686 14.5535 1.70973 14.5287C1.77259 14.5039 1.83104 14.4635 1.88173 14.4097L11.6818 4.02956C11.7721 3.93597 11.8846 3.88494 12.0005 3.88494C12.1165 3.88494 12.229 3.93597 12.3193 4.02956L22.1198 14.4097C22.1704 14.4635 22.2287 14.504 22.2915 14.5288C22.3543 14.5537 22.4202 14.5624 22.4856 14.5544C22.551 14.5464 22.6145 14.522 22.6726 14.4824C22.7306 14.4429 22.782 14.389 22.8239 14.3239L23.8863 12.663C23.9281 12.5976 23.9595 12.5222 23.9786 12.4411C23.9976 12.36 24.0041 12.2749 23.9975 12.1906C23.9909 12.1063 23.9714 12.0245 23.9402 11.9499C23.909 11.8753 23.8666 11.8094 23.8155 11.756Z"
                                    fill="#7166F9" />
                            </svg>
                            <span class="ml-4">Dashboard</span>
                        </a>

                        </a>
                        <a href="{{ route('Resident.Event.index') }}"
                            class="flex items-center px-6 py-3 text-gray-600 hover:bg-blue-100">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2 6H16V4H2V6ZM2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V4C0 3.45 0.195833 2.97917 0.5875 2.5875C0.979167 2.19583 1.45 2 2 2H3V0H5V2H13V0H15V2H16C16.55 2 17.0208 2.19583 17.4125 2.5875C17.8042 2.97917 18 3.45 18 4V9.675C17.6833 9.525 17.3583 9.4 17.025 9.3C16.6917 9.2 16.35 9.125 16 9.075V8H2V18H8.3C8.41667 18.3667 8.55417 18.7167 8.7125 19.05C8.87083 19.3833 9.05833 19.7 9.275 20H2ZM15 21C13.6167 21 12.4375 20.5125 11.4625 19.5375C10.4875 18.5625 10 17.3833 10 16C10 14.6167 10.4875 13.4375 11.4625 12.4625C12.4375 11.4875 13.6167 11 15 11C16.3833 11 17.5625 11.4875 18.5375 12.4625C19.5125 13.4375 20 14.6167 20 16C20 17.3833 19.5125 18.5625 18.5375 19.5375C17.5625 20.5125 16.3833 21 15 21ZM16.675 18.375L17.375 17.675L15.5 15.8V13H14.5V16.2L16.675 18.375Z"
                                    fill="black" />
                            </svg>

                            <span class="ml-4">Events</span>
                        </a>
                        <a
                            href="{{ route('Resident.Project.index') }}"class="flex items-center px-6 py-3 text-gray-600 hover:bg-blue-100">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_2256_1225" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                    y="0" width="24" height="24">
                                    <rect width="24" height="24" fill="#D9D9D9" />
                                </mask>
                                <g mask="url(#mask0_2256_1225)">
                                    <path
                                        d="M2 21V9L10 3L15.375 7.05C14.9583 7.1 14.5667 7.19583 14.2 7.3375C13.8333 7.47917 13.4833 7.66667 13.15 7.9L10 5.5L4 10V19H8V21H2ZM10 21V19.1C10 18.75 10.0875 18.4208 10.2625 18.1125C10.4375 17.8042 10.675 17.5583 10.975 17.375C11.7417 16.925 12.5458 16.5833 13.3875 16.35C14.2292 16.1167 15.1 16 16 16C16.9 16 17.7708 16.1167 18.6125 16.35C19.4542 16.5833 20.2583 16.925 21.025 17.375C21.325 17.5583 21.5625 17.8042 21.7375 18.1125C21.9125 18.4208 22 18.75 22 19.1V21H10ZM12.15 19H19.85C19.2667 18.6667 18.65 18.4167 18 18.25C17.35 18.0833 16.6833 18 16 18C15.3167 18 14.65 18.0833 14 18.25C13.35 18.4167 12.7333 18.6667 12.15 19ZM16 15C15.1667 15 14.4583 14.7083 13.875 14.125C13.2917 13.5417 13 12.8333 13 12C13 11.1667 13.2917 10.4583 13.875 9.875C14.4583 9.29167 15.1667 9 16 9C16.8333 9 17.5417 9.29167 18.125 9.875C18.7083 10.4583 19 11.1667 19 12C19 12.8333 18.7083 13.5417 18.125 14.125C17.5417 14.7083 16.8333 15 16 15ZM16 13C16.2833 13 16.5208 12.9042 16.7125 12.7125C16.9042 12.5208 17 12.2833 17 12C17 11.7167 16.9042 11.4792 16.7125 11.2875C16.5208 11.0958 16.2833 11 16 11C15.7167 11 15.4792 11.0958 15.2875 11.2875C15.0958 11.4792 15 11.7167 15 12C15 12.2833 15.0958 12.5208 15.2875 12.7125C15.4792 12.9042 15.7167 13 16 13Z"
                                        fill="black" />
                                </g>
                            </svg>



                            <span class="ml-4">Projects</span>
                        </a>
                        @if (auth()->check() && auth()->user()->user_type === 'official')
                            <a
                                href="{{ route('Official.OfficialDashboard.index') }}"class="flex items-center px-6 py-3 text-gray-600 hover:bg-blue-100">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_2256_1225" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                        y="0" width="24" height="24">
                                        <rect width="24" height="24" fill="#D9D9D9" />
                                    </mask>
                                    <g mask="url(#mask0_2256_1225)">
                                        <path
                                            d="M2 21V9L10 3L15.375 7.05C14.9583 7.1 14.5667 7.19583 14.2 7.3375C13.8333 7.47917 13.4833 7.66667 13.15 7.9L10 5.5L4 10V19H8V21H2ZM10 21V19.1C10 18.75 10.0875 18.4208 10.2625 18.1125C10.4375 17.8042 10.675 17.5583 10.975 17.375C11.7417 16.925 12.5458 16.5833 13.3875 16.35C14.2292 16.1167 15.1 16 16 16C16.9 16 17.7708 16.1167 18.6125 16.35C19.4542 16.5833 20.2583 16.925 21.025 17.375C21.325 17.5583 21.5625 17.8042 21.7375 18.1125C21.9125 18.4208 22 18.75 22 19.1V21H10ZM12.15 19H19.85C19.2667 18.6667 18.65 18.4167 18 18.25C17.35 18.0833 16.6833 18 16 18C15.3167 18 14.65 18.0833 14 18.25C13.35 18.4167 12.7333 18.6667 12.15 19ZM16 15C15.1667 15 14.4583 14.7083 13.875 14.125C13.2917 13.5417 13 12.8333 13 12C13 11.1667 13.2917 10.4583 13.875 9.875C14.4583 9.29167 15.1667 9 16 9C16.8333 9 17.5417 9.29167 18.125 9.875C18.7083 10.4583 19 11.1667 19 12C19 12.8333 18.7083 13.5417 18.125 14.125C17.5417 14.7083 16.8333 15 16 15ZM16 13C16.2833 13 16.5208 12.9042 16.7125 12.7125C16.9042 12.5208 17 12.2833 17 12C17 11.7167 16.9042 11.4792 16.7125 11.2875C16.5208 11.0958 16.2833 11 16 11C15.7167 11 15.4792 11.0958 15.2875 11.2875C15.0958 11.4792 15 11.7167 15 12C15 12.2833 15.0958 12.5208 15.2875 12.7125C15.4792 12.9042 15.7167 13 16 13Z"
                                            fill="black" />
                                    </g>
                                </svg>

                                <span class="ml-4">Back to Admin</span>
                            </a>
                        @endif


                    </nav>

                </aside>
                <!-- end side bar -->





                <!-- end side bar -->


















                <!-- grid event section -->
                <div class="flex flex-col lg:flex-row lg:space-x-6">
                    <!-- Content Section -->
                    <main class="flex-1 px-8 py-6 space-y-6 bg-gray-50">

                        <section>
                            <x-recent-all-header />





















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
                                        '{{ asset('storage/' . $event->reciept) }}',
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
                                        eventImage, eventBudget, receiptPath, expenseAmount, expenseDescription) {
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
                                            receiptPath: receiptPath,
                                        };

                                        const receiptContainer = document.getElementById('receiptContainer');
                                        const receiptLink = document.getElementById('receiptDownloadLink');
                                        if (receiptPath) {
                                            receiptLink.href = receiptPath; // Set the link to the file
                                            receiptLink.setAttribute('download', 'receipt'); // Force download with a suggested filename
                                            receiptLink.style.display = 'inline'; // Show the link
                                        } else {
                                            receiptContainer.style.display = 'none'; // Hide if no receipt
                                        }



                                        console.log(eventId);
                                        console.log("User: " + userId);
                                        console.log("Current Event Data:", currentEventData);

                                        // Populate Modal 1 fields with event data
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

                                        // Populate budget summary data
                                        document.getElementById('eventName').value = eventData.eventName;
                                        document.getElementById('totalBudget').value =
                                            `₱${parseFloat(eventData.eventBudget).toLocaleString('en-PH', { minimumFractionDigits: 2 })}`; // Total budget
                                        //  document.getElementById('additionalExpenses').value = 0; // Placeholder for additional expenses
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


                                @php
                                    // Shuffle the events array to ensure a random order and pick the first one
                                    $randomEvent = $events->shuffle()->first();
                                @endphp
                                @if ($randomEvent)
                                    <div class="hero min-h-screen mt-3"
                                        style="background-image: url('{{ $randomEvent->eventImage ? asset('storage/' . $randomEvent->eventImage) : '' }}');">
                                        <div class="hero-overlay bg-opacity-60"></div>
                                        <div class="hero-content text-neutral-content text-center">
                                            <div class="max-w-md">
                                                <h1 class="mb-5 text-5xl font-bold">{{ $randomEvent->eventName }}</h1>
                                                <p class="mb-5">
                                                    {{ $randomEvent->eventDescription }}
                                                </p>
                                                @if (!$randomEvent->eventImage)
                                                    <p class="text-xl font-semibold">Events</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p>No events found.</p>
                                @endif




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
