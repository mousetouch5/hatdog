    <div class="slider-container">
        <div class="slider" id="slider">
            @foreach ($events as $event)
                <section class="bg-white shadow-lg rounded-lg p-6 flex flex-col" data-aos="fade-up"
                    data-aos-duration="2000">
                    <img src="{{ asset('storage/' . $event->eventImage) }}" alt="{{ $event->eventName }}"
                        class="rounded-lg w-full mb-4 h-72">
                    <div>
                        <h3 class="text-xl font-semibold">{{ $event->eventName }}</h3>
                        <p class="mt-4 text-sm text-gray-500">{{ $event->eventDescription }}</p>
                        <p class="mt-2 text-sm text-gray-500"><strong>Date:</strong>
                            {{ \Carbon\Carbon::parse($event->eventDate)->format('m/d/Y') }}</p>
                        <p class="mt-2 text-sm text-gray-500"><strong>Time:</strong> {{ $event->eventTime }}</p>
                        <p class="mt-2 text-sm text-gray-500"><strong>Organizer:</strong> {{ $event->organizer }}</p>
                        <p class="mt-2 text-sm text-gray-500"><strong>Location:</strong> {{ $event->eventLocation }}</p>
                    </div>
                </section>
            @endforeach
        </div>
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </div>

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
