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

        <div class="max-w-7xl mx-auto px-4 py-6">
            <!-- Header -->
            <header class="flex justify-between items-center mb-6">
              <h1 class="text-2xl font-bold text-gray-800">Budget Preparation</h1>
             
            </header>
          
            <!-- Table -->
            <div class="overflow-x-auto">
              <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm text-gray-700 bg-white rounded-lg shadow">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Account Code</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Source of Income PARTICULAR</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Past Year (2022)</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Current Year (2023)</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Budget Year (2024)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td rowspan="3" class="border border-gray-300 px-4 py-2 text-center font-medium">588</td>
                    <td colspan="4" class="border border-gray-300 px-4 py-2 font-bold">Property Taxes</td>
                  </tr>
                  <tr>
                    <td class="border border-gray-300 px-4 py-2">Share on Real Property Tax</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">1,245,597.21</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">1,345,244.98</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">1,452,864.60</td>
                  </tr>
                  <tr>
                    <td class="border border-gray-300 px-4 py-2">Share on Real Property Tax on Idle Land</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">0.00</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">0.00</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">0.00</td>
                  </tr>
                  <tr>
                    <td rowspan="2" class="border border-gray-300 px-4 py-2 text-center font-medium">583</td>
                    <td colspan="4" class="border border-gray-300 px-4 py-2 font-bold">Community Tax</td>
                  </tr>
                  <tr>
                    <td class="border border-gray-300 px-4 py-2">Share from (NTA) National Tax Allotment</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">1,245,597.21</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">1,345,244.98</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">1,452,864.60</td>
                  </tr>
                </tbody>
              </table>
            </div>
          
            <!-- Form -->
            <form class="mt-6 flex flex-wrap gap-4">
              <input type="text" placeholder="Account Code" class="flex-1 border border-gray-300 px-3 py-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              <input type="text" placeholder="Source of Income" class="flex-1 border border-gray-300 px-3 py-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              <input type="number" placeholder="Amount of Past Year" class="flex-1 border border-gray-300 px-3 py-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              <input type="number" placeholder="Amount of Current Year" class="flex-1 border border-gray-300 px-3 py-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              <input type="number" placeholder="Amount of Budget Year" class="flex-1 border border-gray-300 px-3 py-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
              <button type="submit" class="bg-gray-700 text-white px-6 py-2 rounded shadow hover:bg-blue-600 transition">Add</button>
            </form>
          
            <!-- Print Button -->
            <button class="mt-4 bg-gray-700 text-white px-6 py-2 rounded shadow hover:bg-gray-800 transition">Print</button>
          </div>
          

      




</x-app-layout>
