<x-app-layout>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                <h2 class="text-xl font-semibold text-gray-700">Survey!</h2>
            </div>


            <div class="container mx-auto mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 ml-4">Survey Responses</h2>
                </div>

                <!-- Table displaying users with buttons -->
                <div class="overflow-x-auto bg-white shadow-md rounded-lg ml-3">
                    <table class="table-auto text-sm text-left text-gray-700">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-xs">User</th>
                                <th class="px-4 py-2 text-xs">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surveyResponses as $response)
                                <tr class="border-b hover:bg-gray-200">
                                    <td class="px-4 py-2 text-sm flex items-center">
                                        <!-- Placeholder Icon (using a default Material Design icon for user) -->
                                        <i
                                            class="material-icons mr-2 text-gray-600 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-2xl">
                                            person
                                        </i>
                                        {{ $response->user->name }}
                                    </td>


                                    <td class="px-4 py-2 text-sm">
                                        <!-- Print Button -->
                                        <button
                                            class="px-3 py-1 bg-gray-700 text-white font-semibold rounded-lg shadow-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300"
                                            onclick="printUserResponse({{ $response->id }})">
                                            <i class="material-icons text-green-500 text-lg mr-2">thumb_up</i>
                                            Like
                                        </button>

                                        <!-- Download Button -->
                                        <button
                                            class="ml-2 px-3 py-1 bg-gray-700 text-white font-semibold rounded-lg shadow-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-300"
                                            onclick="downloadUserResponse({{ $response->id }})">
                                            <i class="material-icons">download</i>
                                        </button>
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
                    // Open a new window with the print-friendly view
                    window.open('/print-survey/' + id, '_blank');
                }

                function downloadUserResponse(id) {
                    // Handle the download functionality for a specific user response
                    window.location.href = '/download-survey/' + id;
                }
            </script>



        </div>
        <!-- Scripts -->

    </div>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</x-app-layout>
