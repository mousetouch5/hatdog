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
            <!-- Title -->
            <div class="p-4 bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-700">Reports</h2>
            </div>

            <!-- Select Date Range Section -->
            <div class="p-6" data-aos="fade-up" data-aos-duration="2000">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Select Date Range to Print Events with Expenses
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <!-- Start Month -->
                    <div class="form-control">
                        <label for="startMonth" class="label">
                            <span class="label-text">Start Month</span>
                        </label>
                        <input type="month" name="startMonth" id="startMonth" class="input input-bordered"
                            value="{{ old('startMonth', now()->format('Y-m')) }}" required>
                        @error('startMonth')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- End Month -->
                    <div class="form-control">
                        <label for="endMonth" class="label">
                            <span class="label-text">End Month</span>
                        </label>
                        <input type="month" name="endMonth" id="endMonth" class="input input-bordered"
                            value="{{ old('endMonth', now()->format('Y-m')) }}" required>
                        @error('endMonth')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Generate Report Button -->
                    <div>
                        <button id="generateButton" class="btn btn-primary w-full mt-4 md:mt-0">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const generateButton = document.getElementById('generateButton');
                    const startMonthInput = document.getElementById('startMonth');
                    const endMonthInput = document.getElementById('endMonth');

                    generateButton.addEventListener('click', function() {
                        const startMonth = startMonthInput.value;
                        const endMonth = endMonthInput.value;

                        if (startMonth && endMonth) {
                            const url = `{{ route('events.print') }}?startMonth=${startMonth}&endMonth=${endMonth}`;
                            window.location.href = url;
                        } else {
                            alert('Please select both start and end months.');
                        }
                    });
                });
            </script>

            <!-- Table Section -->
            <div class="p-4 flex-1 overflow-y-auto" data-aos="fade-up" data-aos-duration="2000">
                <div class="bg-white shadow-md rounded-md overflow-hidden">
                    <table class="table w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Activity Name</th>
                                <th class="px-4 py-2 text-left">Activity Date</th>
                                <th class="px-4 py-2 text-left">Budget</th>
                                <th class="px-4 py-2 text-left">Total Spent</th>
                                <th class="px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $event->eventName }}</td>
                                    <td class="px-4 py-2">
                                        {{ \Carbon\Carbon::parse($event->eventDate)->format('F Y') }}
                                    </td>
                                    <td class="px-4 py-2 text-green-500">
                                        {{ number_format($event->budget, 2) }}
                                    </td>
                                    <td class="px-4 py-2 text-red-500">
                                        @php
                                            $totalExpense = $event->expenses->sum('expense_amount');
                                        @endphp
                                        {{ number_format($totalExpense, 2) }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <button class="btn btn-secondary btn-sm" title="Print"
                                            data-event-id="{{ $event->id }}"
                                            onclick="printEvent({{ $event->id }})">
                                            Print
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Scripts -->
        <script>
            function printEvent(eventId) {
                console.log("clicked");
                // Redirect to backend route for printing event
                window.location.href = `/print-event/${eventId}`;
            }
        </script>

    </div>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</x-app-layout>
