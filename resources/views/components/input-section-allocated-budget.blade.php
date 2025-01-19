
    <!-- Year and Yearly Budget Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-20">
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
            <label for="yearly_budget" class="block text-sm font-medium text-gray-700 mb-1">Year Budget:</label>
            <input 
                type="number" 
                id="yearly_budget" 
                name="yearly_budget"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Enter Budget">
        </div>
    </div>




    <div class="space-y-4">
        <!-- Header Row -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 font-semibold text-gray-700">
            <span>Committee</span>
            <span class="text-center">Allocated Budget</span>
            <span class="text-center">Remaining Balance</span>
        </div>
        <!-- Repeatable Rows for Committees -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <span class="text-gray-700 bg-gray-100 p-3 rounded-md">Committee Chair Infrastructure & Finance</span>
            <input 
                type="number" 
                name="committee_infrastructure_finance_allocated"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
            <input 
                type="number" 
                name="committee_infrastructure_finance_remaining"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <span class="text-gray-700 bg-gray-100 p-3 rounded-md">Committee Chair on Barangay Affairs & Environment</span>
            <input 
                type="number" 
                name="committee_barangay_affairs_allocated"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
            <input 
                type="number" 
                name="committee_barangay_affairs_remaining"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <span class="text-gray-700 bg-gray-100 p-3 rounded-md ">Committee Chair on Education</span>
            <input 
                type="number" 
                name="committee_education_allocated"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
            <input 
                type="number" 
                name="committee_education_remaining"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <span class="text-gray-700 bg-gray-100 p-3 rounded-md">Committee Chair Peace & Order</span>
            <input 
                type="number" 
                name="committee_peace_order_allocated"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
            <input 
                type="number" 
                name="committee_peace_order_remaining"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <span class="text-gray-700 bg-gray-100 p-3 rounded-md">Committee Chair on Laws & Good Governance</span>
            <input 
                type="number" 
                name="committee_laws_governance_allocated"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
            <input 
                type="number" 
                name="committee_laws_governance_remaining"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <span class="text-gray-700 bg-gray-100 p-3 rounded-md">Committee Chair on Elderly, PWD/VAWC</span>
            <input 
                type="number" 
                name="committee_elderly_pwd_allocated"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
            <input 
                type="number" 
                name="committee_elderly_pwd_remaining"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <span class="text-gray-700 bg-gray-100 p-3 rounded-md">Committee Chair on Health & Sanitation/ Nutrition</span>
            <input 
                type="number" 
                name="committee_health_sanitation_allocated"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
            <input 
                type="number" 
                name="committee_health_sanitation_remaining"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <span class="text-gray-700 bg-gray-100 p-3 rounded-md">Committee Chair on Livelihood</span>
            <input 
                type="number" 
                name="committee_livelihood_allocated"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
            <input 
                type="number" 
                name="committee_livelihood_remaining"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 text-center"
                placeholder="₱"
                readonly>
        </div>
    </div>
    
    


<div class="mt-8 text-right">
    <button 
        type="button" 
        class="px-6 py-2 bg-gray-700 text-white rounded-md shadow hover:bg-gray-500 focus:ring-2 focus:ring-indigo-500"
        onclick="my_modal_2.showModal()">
        Save
    </button>
</div>

