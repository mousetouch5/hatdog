 <!-- Modal Structure with Survey Questions -->

 <dialog id="Survey" class="modal">
     <div class="modal-box w-11/12 max-w-5xl">
         <h3 class="text-lg font-bold">Barangay Events and Projects Survey</h3>
         <p class="py-4">This survey aims to understand your experience with events and
             projects held in our barangay. Your responses will help us improve future
             initiatives and better serve the community.</p>

         <!-- Survey Form -->
         <form id="surveyForm">
             @csrf
             <!-- Question 1: How often do you participate in barangay events? -->
             <div class="mb-6">
                 <p class="text-sm font-semibold text-gray-700">1. How often do you participate
                     in barangay events?</p>
                 <div class="mt-2 space-y-2">
                     <label class="inline-flex items-center">
                         <input type="radio" name="participation" value="never" class="form-radio">
                         <span class="ml-2">Never</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="radio" name="participation" value="rarely" class="form-radio">
                         <span class="ml-2">Rarely (once or twice a year)</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="radio" name="participation" value="sometimes" class="form-radio">
                         <span class="ml-2">Sometimes (3-5 times a year)</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="radio" name="participation" value="often" class="form-radio">
                         <span class="ml-2">Often (6 or more times a year)</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="radio" name="participation" value="always" class="form-radio">
                         <span class="ml-2">Always</span>
                     </label>
                 </div>
             </div>

             <!-- Question 2: What types of barangay events do you find most interesting or valuable? -->
             <div class="mb-6">
                 <p class="text-sm font-semibold text-gray-700">2. What types of barangay events
                     do you find most interesting or valuable? (select all that apply)</p>
                 <div class="mt-2 space-y-2">
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_types" value="cultural_celebrations" class="form-checkbox">
                         <span class="ml-2">Cultural celebrations (fiestas, etc.)</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_types" value="sports_tournaments" class="form-checkbox">
                         <span class="ml-2">Sports tournaments</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_types" value="health_fairs" class="form-checkbox">
                         <span class="ml-2">Health fairs/medical missions</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_types" value="clean_up_drives" class="form-checkbox">
                         <span class="ml-2">Clean-up drives/environmental projects</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_types" value="skills_workshops" class="form-checkbox">
                         <span class="ml-2">Skills workshops (e.g., livelihood
                             training)</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_types" value="youth_programs" class="form-checkbox">
                         <span class="ml-2">Youth development programs</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_types" value="community_forums" class="form-checkbox">
                         <span class="ml-2">Community forums/meetings</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_types" value="social_events" class="form-checkbox">
                         <span class="ml-2">Social events (e.g., movie nights)</span>
                     </label>
                 </div>
             </div>

             <!-- Question 3: How do you usually find out about upcoming barangay events? -->
             <div class="mb-6">
                 <p class="text-sm font-semibold text-gray-700">3. How do you usually find out
                     about upcoming barangay events? (select all that apply)</p>
                 <div class="mt-2 space-y-2">
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_info" value="barangay_announcements" class="form-checkbox">
                         <span class="ml-2">Barangay announcements (posters, flyers)</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_info" value="social_media" class="form-checkbox">
                         <span class="ml-2">Barangay social media page</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_info" value="barangay_website" class="form-checkbox">
                         <span class="ml-2">Barangay website</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_info" value="text_alerts" class="form-checkbox">
                         <span class="ml-2">Community text message alerts</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_info" value="community_meetings" class="form-checkbox">
                         <span class="ml-2">Announcements during community meetings</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="event_info" value="word_of_mouth" class="form-checkbox">
                         <span class="ml-2">Word-of-mouth</span>
                     </label>
                 </div>
             </div>

             <!-- Question 4: In your opinion, how have these projects impacted the barangay? -->
             <div class="mb-6">
                 <p class="text-sm font-semibold text-gray-700">4. In your opinion, how have
                     these projects impacted the barangay? (select all that apply)</p>
                 <div class="mt-2 space-y-2">
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="impact" value="improved_infrastructure"
                             class="form-checkbox">
                         <span class="ml-2">Improved infrastructure (roads, drainage,
                             etc.)</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="impact" value="enhanced_safety" class="form-checkbox">
                         <span class="ml-2">Enhanced safety and security</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="impact" value="environmental_sustainability"
                             class="form-checkbox">
                         <span class="ml-2">Increased environmental sustainability</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="impact" value="improved_services" class="form-checkbox">
                         <span class="ml-2">Improved access to basic services (water,
                             sanitation)</span>
                     </label>
                     <label class="inline-flex items-center">
                         <input type="checkbox" name="impact" value="community_development" class="form-checkbox">
                         <span class="ml-2">Boosted community development and livelihood
                             opportunities</span>
                     </label>
                 </div>
             </div>

             <!-- Submit Button -->
             <div class="flex justify-center mt-6">
                 <button type="submit"
                     class="btn bg-cyan-500 text-white hover:bg-cyan-600 rounded-lg px-6 py-2">Submit</button>
             </div>

         </form>

         <!-- Close Button -->
         <div class="modal-action">
             <form method="dialog">
                 <button class="btn">Close</button>
             </form>
         </div>
     </div>
 </dialog>


 <script>
     // resources/js/app.js or in your custom JS file

     document.getElementById('surveyForm').addEventListener('submit', function(e) {
         e.preventDefault();

         let formData = new FormData(this);

         // Prepare the data to be sent to the server
         const data = {
             participation: formData.get('participation'),
             event_types: Array.from(formData.getAll('event_types')),
             event_info: Array.from(formData.getAll('event_info')),
             impact: Array.from(formData.getAll('impact')),
         };

         // Send a POST request to submit the survey
         axios.post('/submit-survey', data)
             .then(response => {
                 console.log(response.data);
                 // Optionally close the modal after submission
                 document.getElementById('Survey').close();
             })
             .catch(error => {
                 console.error(error);
             });
     });
 </script>
