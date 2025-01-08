<div class="flex justify-end mt-5">
    <button class="bg-gray-700 text-white px-6 py-2 rounded shadow hover:bg-blue-600 transition" 
            onclick="my_modal_5.showModal()">Add</button>
  </div>
  
  <!-- Modal -->
  <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box w-11/12 max-w-5xl">

      <h3 class="text-lg font-bold py-4">Budget Planning</h3>
  
      <form id="event-form" method="dialog" class="space-y-4">
        <!-- Title -->
        <div>
          <label for="title" class="block font-medium">Title</label>
          <input type="text" id="title" name="title" class="w-80 border rounded px-3 py-2" placeholder="Enter event title" required>
        </div>
  
        <!-- Date -->
        <div>
          <label for="date" class="block font-medium">Date</label>
          <input type="date" id="date" name="date" class="w-80 border rounded px-3 py-2" required>
        </div>
  
        <!-- Type -->
        <div>
          <label for="type" class="block font-medium">Type</label>
          <select id="type" name="type" class="w-80 border rounded px-3 py-2" required>
            <option value="" disabled selected>Select type</option>
            <option value="event">Event</option>
            <option value="project">Project</option>
          </select>
        </div>
  
        <!-- Expected Budget
        <div>
          <label for="budget" class="block font-medium">Expected Budget</label>
          <input type="number" id="budget" name="budget" class="w-full border rounded px-3 py-2" placeholder="Enter budget" required>
        </div>
        -->

        <!-- Possible Expenses -->
        <div class="space-y-4">
          <label class="block font-medium mb-2">Possible Expenses</label>
          <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
              <!-- Category Selection -->
              <div class="flex flex-col">
                  <label for="category" class="block text-sm font-medium">Category</label>
                  <select 
                      id="category" 
                      name="category" 
                      class="border rounded px-3 py-2 w-full" 
                      required>
                      <option value="" disabled selected>Select category</option>
                      <option value="office_supplies">Office Supplies</option>
                      <option value="travel">Travel</option>
                      <option value="utilities">Utilities</option>
                      <option value="miscellaneous">Miscellaneous</option>
                  </select>
              </div>
              <!-- Item/Type -->
              <div class="flex flex-col">
                  <label for="item" class="block text-sm font-medium">Item/Type</label>
                  <input 
                      type="text" 
                      id="item" 
                      name="item" 
                      class="border rounded px-3 py-2 w-full" 
                      placeholder="Enter item/type" 
                      required>
              </div>
              <!-- Quantity -->
              <div class="flex flex-col">
                  <label for="quantity" class="block text-sm font-medium">Quantity</label>
                  <input 
                      type="number" 
                      id="quantity" 
                      name="quantity" 
                      class="border rounded px-3 py-2 w-full" 
                      placeholder="Enter quantity" 
                      required>
              </div>
              <!-- Amount -->
              <div class="flex flex-col">
                  <label for="amount" class="block text-sm font-medium">Amount</label>
                  <input 
                      type="number" 
                      id="amount" 
                      name="amount" 
                      class="border rounded px-3 py-2 w-full" 
                      placeholder="Enter amount" 
                      required>
              </div>
          </div>
        </div>






        <div class="mt-3">
        <button type="button" id="add-expenses" class="bg-gray-700 text-white px-6 py-2 rounded shadow hover:bg-blue-600 transition">
            Add
          </button>
        </div>
        <!-- Total Expenses -->
        <div>
          <label for="total-expenses" class="block font-medium">Total Expenses</label>
          <input type="text" id="total-expenses" name="total-expenses" class="w-80 border rounded px-3 py-2" readonly>
        </div>
  
        <!-- Modal Actions -->
        <div class="modal-action flex justify-between">
        
          <!-- Save Button -->
          <button type="submit" class="bg-gray-700 text-white  px-3 py-2 rounded shadow hover:bg-green-600 transition">
            Save
          </button>
  
          <!-- Close Button -->
          <button type="button" class="bg-gray-700 text-white  px-3 py-2 rounded shadow hover:bg-red-600 transition" 
                  onclick="my_modal_5.close()">Close</button>
        </div>
      </form>
    </div>
  </dialog>
  
  <script>
    // Script to calculate and display total expenses
    document.getElementById('add-expenses').addEventListener('click', () => {
      const budget = parseFloat(document.getElementById('budget').value) || 0;
      const expenses = parseFloat(document.getElementById('expenses').value) || 0;
      const total = budget + expenses;
      document.getElementById('total-expenses').value = total.toFixed(2);
    });
  </script>
  