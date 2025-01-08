<x-app-layout>


    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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
                    <div class="flex justify-end p-4 ">
                        <button onclick="toggleModal()"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Add
                        </button>


                        <button onclick="toggleModal2()"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 ml-5">
                            History
                        </button>
                    </div>

                    <x-Officials.transactions-table />
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

        <x-Officials.transactions-table2 />
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
                            <input type="text" name="budget" min="0" required
                                oninput="formatExpenseAmount(this)"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="₱0.00">
                        </div>
                        <input type="hidden" name="money_spent" value="123">
                        <!-- Money Spent -->
                        <!-- Received By -->


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



        <script>
            function formatExpenseAmount(input) {
                // Remove all non-digit characters except for the period
                let value = input.value.replace(/[^0-9.]/g, '');

                // Prevent more than one period in the value
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts[1]; // Keep only the first two parts
                }

                // Split the value into integer and decimal parts
                const [integerPart, decimalPart] = value.split('.');

                // Format the integer part with commas
                const formattedInteger = integerPart ? parseInt(integerPart, 10).toLocaleString() : '';

                // Combine integer and decimal parts
                let formattedValue = decimalPart !== undefined ?
                    `${formattedInteger}.${decimalPart.slice(0, 2)}` // Limit decimals to two places
                    :
                    formattedInteger;

                // Prepend the peso sign and update the input field
                input.value = formattedValue ? `₱${formattedValue}` : '';
            }

            // Remove formatting before submission
            document.getElementById('addTransactionForm').addEventListener('submit', function(e) {
                const budgetInput = document.querySelector('input[name="budget"]');
                if (budgetInput) {
                    // Remove peso sign and commas
                    budgetInput.value = budgetInput.value.replace(/[₱,]/g, '');
                }
            });
        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

</x-app-layout>
