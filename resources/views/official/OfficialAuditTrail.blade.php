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
                    <h2 class="text-xl font-semibold text-gray-700"data-aos="fade-up" data-aos-duration="2000">Audit
                        Trail</h2>
                </div>

                <!-- Tabs -->
                <div class="p-4 bg-gray-50" data-aos="fade-up" data-aos-duration="2000">
                    <div class="flex space-x-6 border-b">
                        <button
                            class="py-2 px-4 font-medium text-gray-700 border-b-2 border-blue-600 focus:border-blue-600"
                            id="allButton">All</button>
                        <button class="py-2 px-4 font-medium text-gray-700 hover:border-b-2 hover:border-gray-300"
                            id="organizerButton">Activity Organizer</button>
                        <button class="py-2 px-4 font-medium text-gray-700 hover:border-b-2 hover:border-gray-300"
                            id="budgetButton">Budget Allocation</button>
                        <button class="py-2 px-4 font-medium text-gray-700 hover:border-b-2 hover:border-gray-300"
                            id="expensesButton">Expenses</button>
                        <button class="py-2 px-4 font-medium text-gray-700 hover:border-b-2 hover:border-gray-300"
                            id="actualBudgetButton">Actual Budget Used</button>
                    </div>
                </div>

                <!-- All Table Section (default) -->
                <div class="p-4" id="allTable">
                    <table class="table-auto w-full bg-white shadow-md rounded-md" data-aos="fade-up"
                        data-aos-duration="2000">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Organizer</th>
                                <th class="px-4 py-2 text-left">Event Name</th>
                                <th class="px-4 py-2 text-left">Budget</th>
                                <th class="px-4 py-2 text-left">Expenses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr class="hover:bg-gray-100">
                                    <!-- Organizer -->
                                    <td class="px-4 py-2">{{ $event->organizer }}</td>
                                    <!-- Event Name -->
                                    <td class="px-4 py-2">{{ $event->eventName }}</td>
                                    <!-- Budget -->
                                    <td class="px-4 py-2 text-green-500">₱{{ number_format($event->budget, 2) }}</td>
                                    <!-- Expenses -->
                                    <td class="px-4 py-2 text-red-500">
                                        ₱{{ number_format($event->expenses->sum('expense_amount'), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Event Organizer Table Section -->
                <div class="p-4" id="organizerTable" style="display:none;">
                    <table class="table-auto w-full bg-white shadow-md rounded-md" data-aos="fade-up"
                        data-aos-duration="2000">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Organizer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $event->organizer }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Budget Allocation Table Section -->
                <div class="p-4" id="budgetTable" style="display:none;">
                    <table class="table-auto w-full bg-white shadow-md rounded-md" data-aos="fade-up"
                        data-aos-duration="2000">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Event Name</th>
                                <th class="px-4 py-2 text-left">Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $event->eventName }}</td>
                                    <td class="px-4 py-2 text-green-500">₱{{ number_format($event->budget, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Expenses Table Section -->
                <div class="p-4" id="expensesTable" style="display:none;">
                    <table class="table-auto w-full bg-white shadow-md rounded-md" data-aos="fade-up"
                        data-aos-duration="2000">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Event Name</th>
                                <th class="px-4 py-2 text-left">Expenses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $event->eventName }}</td>
                                    <td class="px-4 py-2 text-red-500">
                                        ₱{{ number_format($event->expenses->sum('expense_amount'), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Actual Budget Used Table Section -->
                <div class="p-4" id="actualBudgetTable" style="display:none;">
                    <table class="table-auto w-full bg-white shadow-md rounded-md" data-aos="fade-up"
                        data-aos-duration="2000">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Event Name</th>
                                <th class="px-4 py-2 text-left">Actual Budget Used</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $event->eventName }}</td>
                                    <td class="px-4 py-2 text-green-500">
                                        ₱{{ number_format($event->budget - $event->expenses->sum('expense_amount'), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <script>
                    document.getElementById('allButton').addEventListener('click', function() {
                        document.getElementById('allTable').style.display = 'block';
                        document.getElementById('organizerTable').style.display = 'none';
                        document.getElementById('budgetTable').style.display = 'none';
                        document.getElementById('expensesTable').style.display = 'none';
                        document.getElementById('actualBudgetTable').style.display = 'none';
                    });

                    document.getElementById('organizerButton').addEventListener('click', function() {
                        document.getElementById('allTable').style.display = 'none';
                        document.getElementById('organizerTable').style.display = 'block';
                        document.getElementById('budgetTable').style.display = 'none';
                        document.getElementById('expensesTable').style.display = 'none';
                        document.getElementById('actualBudgetTable').style.display = 'none';
                    });

                    document.getElementById('budgetButton').addEventListener('click', function() {
                        document.getElementById('allTable').style.display = 'none';
                        document.getElementById('organizerTable').style.display = 'none';
                        document.getElementById('budgetTable').style.display = 'block';
                        document.getElementById('expensesTable').style.display = 'none';
                        document.getElementById('actualBudgetTable').style.display = 'none';
                    });

                    document.getElementById('expensesButton').addEventListener('click', function() {
                        document.getElementById('allTable').style.display = 'none';
                        document.getElementById('organizerTable').style.display = 'none';
                        document.getElementById('budgetTable').style.display = 'none';
                        document.getElementById('expensesTable').style.display = 'block';
                        document.getElementById('actualBudgetTable').style.display = 'none';
                    });

                    document.getElementById('actualBudgetButton').addEventListener('click', function() {
                        document.getElementById('allTable').style.display = 'none';
                        document.getElementById('organizerTable').style.display = 'none';
                        document.getElementById('budgetTable').style.display = 'none';
                        document.getElementById('expensesTable').style.display = 'none';
                        document.getElementById('actualBudgetTable').style.display = 'block';
                    });
                </script>

                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

</x-app-layout>
