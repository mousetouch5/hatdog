<x-app-layout>
    <div class="flex h-full min-h-screen">
        <!-- Sidebar -->
        <x-sidebar class="custom-sidebar-class" />

        <!-- Main Content -->
        <div class="bg-gray-50 flex flex-col items-center justify-center w-full">
            <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 mx-4">
                <!-- Title -->
                <h1 class="text-2xl font-bold mb-8 text-center">Budget Planning</h1>

            
















                            <!-- Allocated Budget input Section -->
                            <!-- input section-->
                            <x-input-section-allocated-budget/>

             
                           
              






















            <!-- Modal -->
            <dialog id="my_modal_2" class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Confirmation</h3>
                    <p class="py-4">Please review the following information carefully. Do you want to save these changes?</p>
                    <div class="modal-action">
                        <!-- Cancel Button -->
                        <button class="btn" onclick="my_modal_2.close()">No</button>



                        <!-- temporary route , waaay pa function gin route ko lng para ma demo ko kay jossa ang flow ka UI -->
                        <!-- Confirm Button -->
                        <button type="button" 
                        onclick="window.location.href='{{ route('Official.BudgetPlanning.index') }}'" 
                         class="btn btn-primary bg-gray-700">Yes</button>


                    </div>
                </div>
                <form method="dialog" class="modal-backdrop">
                    <button class="">Close</button>
                </form>
            </dialog>

            </div>
        </div>
    </div>
</x-app-layout>
