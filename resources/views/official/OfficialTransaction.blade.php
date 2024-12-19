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






        <!-- Grid event section -->
        <div class="flex flex-col lg:flex-row lg:space-x-6 w-full">
            <!-- Content Section -->
            <main class="flex-1 px-8 py-6 space-y-6 bg-gray-50">
                <!-- Title -->
                <div class="p-4 bg-gray-50">
                    <h2 class="text-xl font-semibold text-gray-700" data-aos="fade-up" data-aos-duration="2000">
                        Transaction</h2>
                </div>
                <!-- Expenses Table Section -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden w-full mt-5" data-aos="fade-up"
                    data-aos-duration="2000">


                    <!-- Add Button -->
                    <div class="flex justify-end p-4">
                        <button onclick="toggleModal()"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Add
                        </button>
                    </div>


                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 text-left text-sm font-semibold">
                                <th class="py-3 px-4">Authorized Official</th>
                                <th class="py-3 px-4">Item</th>
                                <th class="py-3 px-4">Date</th>
                                <th class="py-3 px-4">Budget Given</th>

                                <th class="py-3 px-4">Received By</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $trs)
                                <tr class="odd:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <!-- Correct relationship method call -->
                                        {{ $trs->authorizeOfficial ? $trs->authorizeOfficial->name : 'No official assigned' }}
                                    </td>
                                    <td class="py-3 px-4">{{ $trs->description }}</td>
                                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($trs->date)->format('F Y') }}
                                    </td>
                                    <td class="py-3 px-4 text-green-500">{{ $trs->budget }}</td>
                                    <td class="py-3 px-4">{{ $trs->recieveBy->name }}</td>
                                    <td class="py-3 px-4">
                                        {{ $trs->is_approved ? 'Confirmed' : 'Not Confirmed' }}
                                    </td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <a href="{{ route('transactions.print', $trs->id) }}" target="_blank"
                                            class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                            Print
                                        </a>
                                        <a href="{{ route('transactions.download', $trs->id) }}"
                                            class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                                            Download
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Footer -->
                    <div class="p-4">
                        <!-- Horizontal Line -->
                        <hr class="border-gray-300 my-4">
                        <!-- Print All Transactions Button -->
                        <div class="flex justify-end">
                            <a href="{{ route('transactions.printAll') }}" target="_blank"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                Print All Transactions
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>





        <!-- Modal -->
        <div id="addModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg w-1/2">
                <!-- Modal Header -->
                <div class="flex justify-between items-center bg-gray-200 px-4 py-2 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-gray-700">Transaction Reports</h3>
                    <button onclick="toggleModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-4">

                    <form id="addTransactionForm" action="{{ route('transactions.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Authorized Official -->


                        <!-- Item -->
                        <div class="mt-20">
                            <label class="block text-sm font-medium text-gray-700 mt-2">Title</label>
                            <input type="text" name="description" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mt-2">Date</label>
                            <input type="date" name="date" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Budget Given -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mt-2">Budget Given</label>
                            <input type="number" name="budget" min="0" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <input type="hidden" name="money_spent" value="123">
                        <!-- Money Spent -->
                        <!-- Received By -->
                        <div class="mb-4">
                            <label for="reciept" class="block text-sm font-semibold text-gray-700">Reciept
                                Image:</label>
                            <input type="file" id="event_image" name="reciept"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('eventImage')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>


                        <div>
                            <label class="block text-sm font-medium text-gray-700">Recieved By</label>
                            <select id="recieve_by" name="recieve_by" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="" disabled selected>Select a reciever</option>
                                @foreach ($officials as $official)
                                    <option value="{{ $official->id }}">
                                        {{ $official->name }} - {{ $official->position }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-2 bg-gray-200 px-4 py-2 rounded-b-lg">
                            <button type="button" onclick="toggleModal()"
                                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                Cancel
                            </button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                Submit
                            </button>
                        </div>
                    </form>

                </div>


                <script>
                    // Function to toggle the modal visibility
                    function toggleModal() {
                        const modal = document.getElementById('addModal');
                        modal.classList.toggle('hidden');
                    }
                </script>

            </div>
        </div>



        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

</x-app-layout>
