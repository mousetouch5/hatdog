<x-app-layout>
    <div class="flex h-full min-h-screen">
        <!-- Sidebar -->
        <x-sidebar class="custom-sidebar-class" />

        <!-- Main Content -->
        <div class="bg-gray-50 flex flex-col items-center justify-center w-full">
            <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 mx-4">
                <!-- Title -->
                <h1 class="text-2xl font-bold mb-8 text-center">Budget Planning</h1>

              
                            <!-- Allocated Budget Section -->
                            <!-- Ma display nadi boss ang data halin sa inputsection allocated budget-->
                            <x-allocated-budget-section/>

             
                           
              

            </div>
        </div>
    </div>
</x-app-layout>
