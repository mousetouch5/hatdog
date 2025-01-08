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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <!-- Year Input -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year:</label>
                        <select 
                            id="year" 
                            name="year"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" disabled selected>Select Year</option>
                            @for ($i = now()->year; $i >= 2000; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    

                    <!-- Yearly Budget Input -->
                    <div>
                        <label for="yearly_budget" class="block text-sm font-medium text-gray-700 mb-1">Yearly Budget:</label>
                        <input 
                            type="number" 
                            id="yearly_budget" 
                            name="yearly_budget"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter Budget">
                    </div>
                </div>

                            <!-- Allocated Budget Section -->
                <h3 class="text-lg font-semibold mb-6">Allocated Budget</h3>
                <div class="space-y-4">
                    <!-- Repeatable Rows for Committees -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                            <span class="text-gray-700">Committee Chair Infrastructure & Finance</span>
                            <input 
                                type="number" 
                                name="committee_infrastructure_finance"
                                class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                readonly>
                        </div>
                        <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                            <span class="text-gray-700">Committee Chair on Barangay Affairs & Environment</span>
                            <input 
                                type="number" 
                                name="committee_barangay_affairs"
                                class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                readonly>
                        </div>
                        <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                            <span class="text-gray-700">Committee Chair on Education</span>
                            <input 
                                type="number" 
                                name="committee_education"
                                class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                readonly>
                        </div>
                        <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                            <span class="text-gray-700">Committee Chair Peace & Order</span>
                            <input 
                                type="number" 
                                name="committee_peace_order"
                                class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                readonly>
                        </div>
                        <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                            <span class="text-gray-700">Committee Chair on Laws & Good Governance</span>
                            <input 
                                type="number" 
                                name="committee_laws_governance"
                                class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                readonly>
                        </div>
                        <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                            <span class="text-gray-700">Committee Chair on Elderly, PWD/VAWC</span>
                            <input 
                                type="number" 
                                name="committee_elderly_pwd"
                                class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                readonly>
                        </div>
                        <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                            <span class="text-gray-700">Committee Chair on Health & Sanitation/ Nutrition</span>
                            <input 
                                type="number" 
                                name="committee_health_sanitation"
                                class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                readonly>
                        </div>
                        <div class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                            <span class="text-gray-700">Committee Chair on Livelihood</span>
                            <input 
                                type="number" 
                                name="committee_livelihood"
                                class="w-32 p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                readonly>
                        </div>
                    </div>
                </div>


                <div class="mt-5">
                    <button 
                        type="button" 
                        onclick="window.location.href='{{ route('Official.CalendarActivities.index') }}'" 
                        class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500">
                        Calendar of Activities
                    </button>
                </div>
                


             
                            <!-- Save Button -->
                <div class="mt-8 text-right">
                    <button 
                        type="button" 
                        class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500"
                        onclick="my_modal_2.showModal()">
                        Save
                    </button>
                </div>

            <!-- Modal -->
            <dialog id="my_modal_2" class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Confirmation</h3>
                    <p class="py-4">Please review the following information carefully. Do you want to save these changes?</p>
                    <div class="modal-action">
                        <!-- Cancel Button -->
                        <button class="btn" onclick="my_modal_2.close()">No</button>

                        <!-- Confirm Button -->
                        <button type="submit" class="btn btn-primary bg-gray-700">Yes</button>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop">
                    <button class="">Close</button>
                </form>
            </dialog>

            </div>
        </div>
    </div>
</x-app-layout>
