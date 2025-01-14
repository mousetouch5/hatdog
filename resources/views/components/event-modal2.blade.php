 <!-- Main Modal -->
 <meta name="csrf-token" content="{{ csrf_token() }}">

 <dialog id="my_modal_1" class="modal">
     <div class="modal-box">
         <h3 class="text-lg font-bold">Event Details</h3>
         <div class="space-y-4">
             <!-- Readonly Input Fields with Sample Data -->
             <div>
                 <label for="eventDate" class="block text-sm font-medium text-gray-700">Date</label>
                 <input type="date" id="eventDate" class="input input-bordered w-full" readonly
                     style="border: none; background: transparent; padding: 0;">
             </div>
             <div>
                 <label for="eventTime" class="block text-sm font-medium text-gray-700">Time</label>
                 <input type="time" id="eventTime" class="input input-bordered w-full" readonly
                     style="border: none; background: transparent; padding: 0;">
             </div>
             <div>
                 <label for="eventDescription" class="block text-sm font-medium text-gray-700">Description</label>
                 <textarea id="eventDescription" class="textarea w-full focus:outline-none focus:ring-0 focus:border-transparent"
                     readonly></textarea>

             </div>
             <div>
                 <label for="eventLocation" class="block text-sm font-medium text-gray-700">Location</label>
                 <input type="text" id="eventLocation" class="input input-bordered w-full" readonly
                     style="border: none; background: transparent; padding: 0;">
             </div>
             <div>
                 <label for="eventOrganizer" class="block text-sm font-medium text-gray-700">Organizer</label>
                 <input type="text" id="eventOrganizer" class="input input-bordered w-full" readonly
                     style="border: none; background: transparent; padding: 0;">
             </div>
             <button type="button" class="btn btn-primary w-full mt-4" onclick="openBudgetModal()">Budget
                 Breakdown</button>



             <!-- Image -->
             <div>
                 <img id="eventImage" src="" alt="Event Image" class="rounded-lg w-full h-40 object-cover">
             </div>



             <div id="receiptContainer" class="mt-4">
                 <a id="receiptDownloadLink" href="#" style="display: none;"
                     class="inline-block px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                     Download Receipt
                 </a>
             </div>

             <!-- Inside the form -->
             <form id="likeUnlikeForm">
                 <h1 class="text-xl font-semibold mt-4">Like or Unlike</h1>
                 <div class="flex items-center space-x-4 mt-2">
                     <div>
                         <input type="radio" id="like" name="like_unlike" value="true"
                             class="radio radio-primary">
                         <label for="like" class="ml-2">Like</label>
                     </div>
                     <div>
                         <input type="radio" id="unlike" name="like_unlike" value="false"
                             class="radio radio-secondary">
                         <label for="unlike" class="ml-2">Unlike</label>
                     </div>
                 </div>

                 <!-- Submit button -->
                 <button type="button" class="btn btn-primary mt-4" onclick="submitLikeUnlike()">Submit</button>
             </form>
         </div>

         <div class="modal-action">
             <form method="dialog">
                 <button class="btn">Close</button>
             </form>
         </div>
     </div>
 </dialog>


 <script>
     function submitLikeUnlike() {
         const liked = document.querySelector('input[name="like_unlike"]:checked');

         if (!liked) {
             alert('Please select like or unlike');
             return;
         }

         const eventId = currentEventData.eventId; // Assuming currentEventData holds the event data with eventId
         const userId = currentEventData.userId; // The logged-in user's ID

         // Prepare the data to be sent to the server
         const data = {
             user_id: userId,
             event_id: eventId,
             liked: liked.value === 'true', // Convert to boolean
             _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
         };

         // Send the data via AJAX
         fetch('/store-like-unlike', {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json',
                     'Accept': 'application/json', // Add this header to tell the server you're expecting JSON
                 },
                 body: JSON.stringify(data),
             })
             .then(response => {
                 if (!response.ok) {
                     // Handle HTTP errors (e.g., 403, 500)
                     return response.json().then(data => {
                         if (data.error) {
                             throw new Error(data.error); // Use the error message from the response
                         } else {
                             throw new Error('An unexpected error occurred.');
                         }
                     });
                 }
                 return response.json(); // Parse JSON for successful responses
             })
             .then(data => {
                 if (data.success) {
                     alert('Your response has been saved');
                     document.getElementById('my_modal_1').close(); // Close modal on success
                 }
             })
             .catch(error => {
                 console.log('Error:', error.message);
                 console.log(error.message); // Display the error message to the user
             });
     }
 </script>
