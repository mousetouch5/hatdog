<div class="flex justify-end mt-5">
    <button class="bg-gray-700 text-white px-6 py-2 rounded shadow hover:bg-blue-600 transition" 
            onclick="my_modal_5.showModal()">Add</button>
  </div>
  
  <!-- Modal -->
  <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
      <h3 class="text-lg font-bold py-4">Budget Planning</h3>
  
      <form id="event-form" method="dialog" class="space-y-4">
        <!-- Title -->
        <div>
          <label for="title" class="block font-medium">Title</label>
          <input type="text" id="title" name="title" class="w-full border rounded px-3 py-2" placeholder="Enter event title" required>
        </div>
  
        <!-- Date -->
        <div>
          <label for="date" class="block font-medium">Date</label>
          <input type="date" id="date" name="date" class="w-full border rounded px-3 py-2" required>
        </div>
  
        <!-- Type -->
        <div>
          <label for="type" class="block font-medium">Type</label>
          <select id="type" name="type" class="w-full border rounded px-3 py-2" required>
            <option value="" disabled selected>Select type</option>
            <option value="event">Event</option>
            <option value="project">Project</option>
          </select>
        </div>
  
        <!-- Expected Budget -->
        <div>
          <label for="budget" class="block font-medium">Expected Budget</label>
          <input type="number" id="budget" name="budget" class="w-full border rounded px-3 py-2" placeholder="Enter budget" required>
        </div>
  
        <!-- Possible Expenses -->
        <div>
          <label for="expenses" class="block font-medium">Possible Expenses</label>
          <input type="number" id="expenses" name="expenses" class="w-full border rounded px-3 py-2" placeholder="Enter expenses" required>
        </div>
  
        <div class="mt-3">
        <button type="button" id="add-expenses" class="bg-gray-700 text-white px-6 py-2 rounded shadow hover:bg-blue-600 transition">
            Add
          </button>
        </div>
        <!-- Total Expenses -->
        <div>
          <label for="total-expenses" class="block font-medium">Total Expenses</label>
          <input type="text" id="total-expenses" name="total-expenses" class="w-full border rounded px-3 py-2" readonly>
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
  