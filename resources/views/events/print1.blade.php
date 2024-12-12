<div class="container">
    <h2>Events Report</h2>
    <p>From: {{ \Carbon\Carbon::parse($startMonth)->format('F Y') }} To:
        {{ \Carbon\Carbon::parse($endMonth)->format('F Y') }}</p>

    @if ($events->isEmpty())
        <div class="alert">
            No events found for the selected date range.
        </div>
    @else
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th class="budget-column">Budget</th>
                        <th>Expenses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $event->eventName }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->eventStartDate)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->eventEndDate)->format('Y-m-d') }}</td>
                            <td class="budget-column">{{ number_format($event->budget, 2) }}</td>
                            <td>
                                @if ($event->expenses->isEmpty())
                                    <span class="text-muted">No expenses recorded.</span>
                                @else
                                    <ul>
                                        @foreach ($event->expenses as $expense)
                                            <li>
                                                <strong>{{ $expense->expense_description }}:</strong>
                                                {{ number_format($expense->expense_amount, 2) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Calculate Total Expenses -->
        @php
            $totalExpenses = $events
                ->flatMap(function ($event) {
                    return $event->expenses;
                })
                ->sum('expense_amount');
        @endphp

        <!-- Display Total Expenses -->
        <div class="total-expenses">
            Total Expenses: <span>{{ number_format($totalExpenses, 2) }}</span>
        </div>
    @endif
</div>



<script>
    window.print();
</script>
<style>
    <style>

    /* Style for the overall container */
    .container {
        max-width: 1000px;
        margin-top: 50px;
    }

    /* Styling for the page title */
    h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Styling for the date range text */
    p {
        font-size: 1.1rem;
        color: #555;
        text-align: center;
    }

    /* Styling for the warning message when no events are found */
    .alert {
        font-size: 1.1rem;
        color: #d9534f;
        background-color: #f9f9f9;
        border-color: #f2dede;
        text-align: center;
        padding: 15px;
        border-radius: 5px;
    }

    /* Style for the table */
    table {
        width: 100%;
        margin-top: 30px;
        border-collapse: collapse;
    }

    /* Styling for table headers */
    th {
        background-color: #343a40;
        color: #fff;
        padding: 12px;
        text-align: left;
    }

    /* Styling for table cells */
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    /* Hover effect for table rows */
    tr:hover {
        background-color: #f1f1f1;
    }

    /* Styling for the expense list inside table */
    ul {
        list-style-type: none;
        padding-left: 0;
    }

    ul li {
        font-size: 1rem;
        margin-bottom: 5px;
    }

    /* Styling for total expenses */
    .total-expenses {
        font-size: 1.5rem;
        font-weight: 600;
        text-align: right;
        margin-top: 30px;
    }

    .total-expenses span {
        color: #e74c3c;
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {

        table th,
        table td {
            padding: 8px;
        }

        .total-expenses {
            font-size: 1.2rem;
        }
    }

    /* Styling for the Budget column */
    .budget-column {
        color: #28a745;
        font-weight: bold;
    }
</style>

</style>
