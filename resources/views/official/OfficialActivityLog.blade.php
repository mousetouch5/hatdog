<x-app-layout>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>


    <div class="flex h-screen items-center justify-center bg-gray-50">
        <x-sidebar class="custom-sidebar-class" />
        </aside>




        <!-- Main Content -->
        <div class="w-3/4 bg-white shadow-lg h-[90vh] flex flex-col">
            <div class="flex-1 flex flex-col">
                <!-- Title -->
                <div class="p-4 bg-gray-50">
                    <h2 class="text-xl font-semibold text-gray-700">Acitivty Logs</h2>
                </div>



                <!-- New Table Section -->
                <div class="p-4" data-aos="fade-up" data-aos-duration="2000">

                    <!-- Table -->
                    <div class="bg-white shadow-md rounded-md overflow-hidden">
                        <table class="table-auto w-full">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-4 py-2 text-left">ID</th>
                                    <th class="px-4 py-2 text-left">Events</th>
                                    <th class="px-4 py-2 text-left">Timestamp</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr>
                                        <td class="px-4 py-2">{{ $event->id }}</td>
                                        <td class="px-4 py-2">{{ $event->eventName }}</td>
                                        <td class="px-4 py-2">{{ $event->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Scripts -->
                <script>
                    // Toggle Add Event Modal
                    function toggleAddModal() {
                        const modal = document.getElementById('addEventModal');
                        modal.classList.toggle('hidden');
                    }

                    // Attach event listener to Print buttons
                    document.querySelectorAll('.print-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const eventId = this.getAttribute('data-event-id');
                            // Redirect to backend route for printing event
                            window.location.href = `/print-event/${eventId}`;
                        });
                    });
                </script>



            </div>
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</x-app-layout>
