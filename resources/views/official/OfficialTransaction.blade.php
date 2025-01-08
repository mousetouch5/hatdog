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



        <aside class="lg:w-1/3 w-full mt-5 lg:mt-0" data-aos="fade-left" data-aos-duration="2000">
            <div class="bg-white shadow-lg rounded-lg p-6 relative">
                <div class="bg-white shadow-md rounded-lg w-80 p-4">
                    <!-- Community Outreach Budget -->
                    <div class="bg-cyan-500 text-white rounded-lg p-4 text-center mb-4">
                        <!--calendar-->
                        <button id="openModal"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none absolute left-12 top-11">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0 18.125C0 19.1602 0.959821 20 2.14286 20H17.8571C19.0402 20 20 19.1602 20 18.125V7.5H0V18.125ZM14.2857 10.4688C14.2857 10.2109 14.5268 10 14.8214 10H16.6071C16.9018 10 17.1429 10.2109 17.1429 10.4688V12.0312C17.1429 12.2891 16.9018 12.5 16.6071 12.5H14.8214C14.5268 12.5 14.2857 12.2891 14.2857 12.0312V10.4688ZM14.2857 15.4688C14.2857 15.2109 14.5268 15 14.8214 15H16.6071C16.9018 15 17.1429 15.2109 17.1429 15.4688V17.0312C17.1429 17.2891 16.9018 17.5 16.6071 17.5H14.8214C14.5268 17.5 14.2857 17.2891 14.2857 17.0312V15.4688ZM8.57143 10.4688C8.57143 10.2109 8.8125 10 9.10714 10H10.8929C11.1875 10 11.4286 10.2109 11.4286 10.4688V12.0312C11.4286 12.2891 11.1875 12.5 10.8929 12.5H9.10714C8.8125 12.5 8.57143 12.2891 8.57143 12.0312V10.4688ZM8.57143 15.4688C8.57143 15.2109 8.8125 15 9.10714 15H10.8929C11.1875 15 11.4286 15.2109 11.4286 15.4688V17.0312C11.4286 17.2891 11.1875 17.5 10.8929 17.5H9.10714C8.8125 17.5 8.57143 17.2891 8.57143 17.0312V15.4688ZM2.85714 10.4688C2.85714 10.2109 3.09821 10 3.39286 10H5.17857C5.47321 10 5.71429 10.2109 5.71429 10.4688V12.0312C5.71429 12.2891 5.47321 12.5 5.17857 12.5H3.39286C3.09821 12.5 2.85714 12.2891 2.85714 12.0312V10.4688ZM2.85714 15.4688C2.85714 15.2109 3.09821 15 3.39286 15H5.17857C5.47321 15 5.71429 15.2109 5.71429 15.4688V17.0312C5.71429 17.2891 5.47321 17.5 5.17857 17.5H3.39286C3.09821 17.5 2.85714 17.2891 2.85714 17.0312V15.4688ZM17.8571 2.5H15.7143V0.625C15.7143 0.28125 15.3929 0 15 0H13.5714C13.1786 0 12.8571 0.28125 12.8571 0.625V2.5H7.14286V0.625C7.14286 0.28125 6.82143 0 6.42857 0H5C4.60714 0 4.28571 0.28125 4.28571 0.625V2.5H2.14286C0.959821 2.5 0 3.33984 0 4.375V6.25H20V4.375C20 3.33984 19.0402 2.5 17.8571 2.5Z"
                                    fill="#FDFDFD" />
                            </svg>
                        </button>
                        <h2 class="text-sm font-semibold">Community Outreach</h2>
                        <p class="text-xs">Total Budget</p>
                        <p class="text-2xl font-bold">₱22,000.00</p>
                        <p class="text-xs">Total Budget Used</p>
                        <p class="text-2xl font-bold">${{ number_format($totalBudget, 2) }}</p>
                        <p class="text-xs">Total Remaining Budget</p>
                        <p class="text-2xl font-bold">₱22,000.00</p>
                    </div>
                </div>
        </aside>

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
