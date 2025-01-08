<x-app-layout>
    <div class="flex h-full min-h-screen">
        <!-- Sidebar -->
        <x-sidebar class="custom-sidebar-class" />

        <!-- Main Content -->
        <div class="bg-gray-100 flex flex-col items-center justify-center w-full">
            <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 mx-4">
                <!-- Title -->
                <h1 class="text-2xl font-bold mb-8 text-center">Budget Planning</h1>

                <!-- Year and Yearly Budget Section -->


                <!-- Allocated Budget Section -->
                <h3 class="text-lg font-semibold mb-6">Allocated Budget</h3>
                <div class="space-y-4">
                    <!-- Repeatable Rows for Committees -->
                    <div class="space-y-4">
                        <!-- Repeatable Rows for Committees -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($committeesData as $data)
                                <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                                    <!-- Display the original committee name -->
                                    <span class="text-gray-700">{{ $data['committee_name'] }}</span>
                                </div>
                                <div class="flex gap-2">
                                    <!-- Price input field for budget -->
                                    <input type="text" name="{{ Str::snake($data['committee_name']) }}_price"
                                        class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500"
                                        value="₱{{ number_format($data['budget'], 2) }}" readonly>
                                    <!-- Budget of each committee -->

                                    <!-- New input field for remaining budget -->
                                    <input type="text" name="{{ Str::snake($data['committee_name']) }}_additional"
                                        class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500"
                                        value="₱{{ number_format($data['remaining_budget'], 2) }}" readonly>
                                    <!-- Remaining budget -->
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="mt-5">
                    <button type="button"
                        onclick="window.location.href='{{ route('Official.CalendarActivities.index') }}'"
                        class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500">
                        Calendar of Activities
                    </button>
                </div>


                <!-- Save Button -->
                <div class="mt-8 text-right">
                    <a href="{{ route('Official.BudgetPlanningEdit.index') }}">
                        <button type="button"
                            class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500">
                            Add
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
