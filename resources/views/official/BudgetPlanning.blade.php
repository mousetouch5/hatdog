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

             
                           
              

            <!-- Modal -->
            <dialog id="my_modal_2" class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Confirmation</h3>
                    <p class="py-4">Please review the following information carefully. Do you want to save these changes?</p>
                    <div class="modal-action">
                        <!-- Cancel Button -->
                        <button class="btn" onclick="my_modal_2.close()">No</button>

                        <!-- Confirm Button -->
                        <button type="submit" class="btn btn-primary bg-gray-700">Yes</button>
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
