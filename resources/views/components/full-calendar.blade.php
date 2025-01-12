 <!-- FullCalendar -->
 <div id="Liquidcalendar" class="p-4 bg-white rounded-lg shadow"></div>


 <!-- FullCalendar JS -->
 <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>



 <script>
     document.addEventListener('DOMContentLoaded', function() {
         var calendarEl = document.getElementById('Liquidcalendar');
         var calendar = new FullCalendar.Calendar(calendarEl, {
             initialView: 'dayGridMonth',
             headerToolbar: {
                 left: 'prev,next today',
                 center: 'title',
                 right: 'dayGridMonth,timeGridWeek,timeGridDay'
             },
             events: {!! json_encode($events) !!}, // Pass events as JSON
             contentHeight: 500,
             fixedWeekCount: false
         });
         calendar.render();
     });
 </script>
