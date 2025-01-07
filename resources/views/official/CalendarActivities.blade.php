<x-app-layout>


    <div class="flex h-full min-h-screen">
        <!-- Sidebar -->
        <x-sidebar class="custom-sidebar-class" />

            <!-- TailwindCSS -->
            <script src="https://cdn.tailwindcss.com"></script>
            <!-- FullCalendar CSS -->
            <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet">
        </head>
        <div class="bg-gray-100 flex justify-center items-center min-h-screen w-full ml-10">
        
            <div class="w-full max-w-4xl bg-white rounded-lg shadow p-4">
            


                <!-- full calendar component -->
                <x-full-calendar/>
               <!--Modal Budget Planing component -->
                <x-modal-budget-planning/>

               

            

         
      <div>
        

</x-app-layout>
