 <!-- Main Modal -->
 <dialog id="my_modal_1" class="modal">
     <div class="modal-box">
         <h3 class="text-lg font-bold">Event Details</h3>
         <div class="space-y-4">
             <!-- Readonly Input Fields with Sample Data -->
             <div>
                 <label for="eventDate" class="block text-sm font-medium text-gray-700">Date</label>
                 <input type="date" id="eventDate"class="input input-bordered w-full" readonly
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




             <div class="mt-4">
                 <!-- Display Like and Unlike Counts -->
                 <h4 class="text-sm font-medium text-gray-700">
                     Survey Responses: <span id="surveyCount">0</span>
                 </h4>
                 <div class="flex space-x-4 mt-2">
                     <div>
                         <span id="likeCount" class="font-bold text-green-600">0</span> Likes
                     </div>
                     <div>
                         <span id="unlikeCount" class="font-bold text-red-600">0</span> Unlikes
                     </div>
                 </div>
             </div>

             <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

             <script>
                 function fetchSurveyCounts() {
                     const eventId = currentEventData.eventId;

                     if (!eventId) {
                         console.log("Event ID is missing!");
                         return;
                     }

                     $.ajax({
                         url: '/survey-count',
                         method: 'GET',
                         data: {
                             event_id: eventId
                         },
                         success: function(response) {
                             console.log("Survey Counts:", response);
                             $('#likeCount').text(response.likeCount);
                             $('#unlikeCount').text(response.unlikeCount);
                             $('#surveyCount').text(response.totalCount);
                         },
                         error: function() {
                             console.log('Failed to fetch survey counts. Please try again.');
                         }
                     });
                 }
             </script>

         </div>

         <div class="modal-action">
             <form method="dialog">
                 <button class="btn">Close</button>
             </form>
         </div>
     </div>
 </dialog>
