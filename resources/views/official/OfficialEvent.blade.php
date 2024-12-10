<x-app-layout>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <div class="flex h-full min-h-screen">
        <!-- Sidebar -->
        <x-sidebar class="custom-sidebar-class" />
        </aside>
        <!-- end side bar -->






        <!-- Grid event section -->
        <div class="flex flex-col lg:flex-row lg:space-x-6 w-full">
            <!-- Content Section -->
            <main class="flex-1 px-8 py-6 space-y-6 bg-gray-50">
                <!-- Title -->
                <div class="p-4 bg-gray-50">
                    <h2 class="text-xl font-semibold text-gray-700">Events</h2>
                </div>












                <div class="relative w-full" data-aos="fade-up" data-aos-duration="2000">
                    <!-- Slider Container -->
                    <div class="carousel w-full relative" id="carousel">
                        @foreach ($events as $event)
                            <div id="event-{{ $loop->index }}"
                                class="carousel-item w-full flex flex-col {{ $loop->first ? '' : 'hidden' }}">
                                <img src="{{ asset('storage/' . $event->eventImage) }}" alt="{{ $event->eventName }}"
                                    class="rounded-lg w-full mb-4 h-72 object-cover">
                                <div class="px-4">
                                    <h3 class="text-xl font-semibold">{{ $event->eventName }}</h3>
                                    <p class="mt-4 text-sm text-gray-500">
                                        {{ $event->eventDescription }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation Buttons -->
                    <button id="prev-btn"
                        class="absolute left-2 top-1/2 transform -translate-y-1/2 btn btn-circle btn-sm bg-gray-800 text-white">
                        ‹
                    </button>
                    <button id="next-btn"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 btn btn-circle btn-sm bg-gray-800 text-white">
                        ›
                    </button>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const slides = document.querySelectorAll('.carousel-item'); // All slides
                        const nextButton = document.getElementById('next-btn'); // Next button
                        const prevButton = document.getElementById('prev-btn'); // Previous button
                        let currentIndex = 0; // Start with the first slide

                        // Function to show the current slide
                        const showSlide = (index) => {
                            slides.forEach((slide, i) => {
                                slide.classList.toggle('hidden', i !==
                                    index); // Show the current slide, hide the others
                            });
                        };

                        // Go to the next slide
                        const nextSlide = () => {
                            currentIndex = (currentIndex + 1) % slides.length; // Wrap around to the first slide
                            showSlide(currentIndex);
                        };

                        // Go to the previous slide
                        const prevSlide = () => {
                            currentIndex = (currentIndex - 1 + slides.length) % slides
                                .length; // Wrap around to the last slide
                            showSlide(currentIndex);
                        };

                        // Next/Prev Button Click Handlers
                        nextButton.addEventListener('click', nextSlide);
                        prevButton.addEventListener('click', prevSlide);

                        // Initialize the first slide to be shown
                        showSlide(currentIndex);
                    });
                </script>






                <select id="event-selector" class="select select-bordered w-full max-w-xs">
                    <option disabled selected value="">Show Break Down</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->eventName }}</option>
                    @endforeach
                </select>

                <x-events.event-edit-button />







                <!-- Expenses Table -->
                @foreach ($expenses as $expenseGroup)
                    <div class="expense-group bg-white shadow-md rounded-lg overflow-hidden w-full mt-5"
                        data-event-id="{{ $expenseGroup['id'] }}" data-aos="fade-left" data-aos-duration="2000"
                        id="expense-group-{{ $expenseGroup['id'] }}" style="display: none;">
                        <!-- Hidden by default -->
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 text-left text-sm font-semibold">
                                    <th class="py-3 px-4">Expenses</th>
                                    <th class="py-3 px-4">Date</th>
                                    <th class="py-3 px-4">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenseGroup['items'] as $expense)
                                    <tr class="{{ $loop->odd ? 'odd:bg-gray-50' : '' }}">
                                        <td class="py-3 px-4">{{ $expense['name'] }}</td>
                                        <td class="py-3 px-4">{{ $expense['date'] }}</td>
                                        <td class="py-3 px-4 text-red-500">
                                            -₱{{ number_format($expense['amount'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-200">
                                    <td colspan="2" class="py-3 px-4 font-semibold text-right">Total:</td>
                                    <td class="py-3 px-4 font-semibold text-red-600">
                                        ₱{{ number_format($expenseGroup['total'], 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endforeach
            </main>
        </div>





        <script>
            // JavaScript for Dropdown Filtering
            document.getElementById('event-selector').addEventListener('change', function() {
                const selectedEventId = this.value; // Get selected event ID
                const expenseGroups = document.querySelectorAll('.expense-group');

                // Show/Hide Expense Groups Based on Selection
                expenseGroups.forEach(group => {
                    if (group.getAttribute('data-event-id') === selectedEventId) {
                        group.style.display = 'block'; // Show matched group
                    } else {
                        group.style.display = 'none'; // Hide other groups
                    }
                });
            });
        </script>















        <script>
            let slideIndex = 0;

            function showSlides() {
                const slides = document.querySelectorAll('.slider section');
                if (slides.length === 0) return; // No slides to show

                const offset = -slideIndex * 100; // Each slide takes up 100% of the width
                document.querySelector('.slider').style.transform = `translateX(${offset}%)`;
            }

            function moveSlide(n) {
                const slides = document.querySelectorAll('.slider section');

                slideIndex += n;

                if (slideIndex >= slides.length) {
                    slideIndex = 0; // Loop back to the first slide
                } else if (slideIndex < 0) {
                    slideIndex = slides.length - 1; // Loop to the last slide
                }

                showSlides();
            }

            // Initialize the slider on page load
            document.addEventListener('DOMContentLoaded', () => {
                showSlides();
            });
        </script>

        <style>
            .slider-container {
                position: relative;
                max-width: 600px;
                /* Adjust as needed */
                margin: auto;
                overflow: hidden;
            }

            .slider {
                display: flex;
                transition: transform 0.5s ease-in-out;
                /* Smooth transition */
            }

            section {
                min-width: 100%;
                /* Each section takes full width */
            }

            .prev,
            .next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background-color: rgba(255, 255, 255, 0.8);
                border: none;
                cursor: pointer;
            }

            .prev {
                left: 10px;
            }

            .next {
                right: 10px;
            }
        </style>













        <!-- Right-Side Content Section -->
        <aside class="lg:w-1/3 w-full mt-5 lg:mt-0" data-aos="fade-right" data-aos-duration="2000">
            <div class="bg-white shadow-lg rounded-lg p-6 relative">
                <div class="bg-white shadow-md rounded-lg w-80 p-4">

                    <x-community-outreach />
                    <!-- Barangay Officials -->
                    <x-barangay-officials />
        </aside>
    </div>
    </div>

    <script>
        AOS.init();
    </script>
</x-app-layout>
