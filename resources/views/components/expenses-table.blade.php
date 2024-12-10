<div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Expenses</h2>
    <!-- Scrollable container -->
    <div class="overflow-x-auto max-h-64">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-200 text-gray-600 text-left text-sm font-semibold">
                    <th class="py-3 px-4">Expenses</th>
                    <th class="py-3 px-4">Date</th>
                    <th class="py-3 px-4">Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through events and expenses -->
                @foreach ($events as $event)
                    @foreach ($event->expenses as $expense)
                        <tr class="border-b">
                            <td class="py-2 text-gray-700">
                                {{ $expense->expense_description ?? 'No Description' }}
                            </td>
                            <td class="py-2 text-gray-700">
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('m/d/Y') }}
                            </td>
                            <td class="py-2 text-red-500">
                                ₱{{ number_format($expense->expense_amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex justify-between mt-4">
        <span class="font-semibold text-lg text-red-500">Total:
            ₱{{ number_format($totalAmount, 2) }}</span>
    </div>
</div>
