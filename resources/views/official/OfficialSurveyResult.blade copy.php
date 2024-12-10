    <div class="container mx-auto mt-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Survey Responses</h2>
        </div>

        <!-- Table displaying users with buttons -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto text-sm text-left text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surveyResponses as $response)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $response->user->name }}</td>
                            <td class="px-6 py-3">
                                <!-- Print Button -->
                                <button
                                    class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-300"
                                    onclick="printUserResponse({{ $response->id }})">Print</button>

                                <!-- Download Button -->
                                <button
                                    class="ml-2 px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-300"
                                    onclick="downloadUserResponse({{ $response->id }})">Download</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts for print and download -->
    <script>
        function printUserResponse(id) {
            // Handle the print functionality for a specific user response
            window.open('/print-survey/' + id, '_blank');
        }

        function downloadUserResponse(id) {
            // Handle the download functionality for a specific user response
            window.location.href = '/download-survey/' + id;
        }
    </script>
