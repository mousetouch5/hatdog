<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f7f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(to right, #3498db, #2c3e50);
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        h2 {
            margin: 0;
            font-size: 28px;
        }

        .date-range {
            font-size: 16px;
            margin-top: 10px;
            opacity: 0.8;
        }

        .alert {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 20px;
            text-align: center;
        }

        .table-responsive {
            overflow-x: auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            color: #555;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #f1f3f5;
        }

        .budget-column {
            color: #28a745;
            font-weight: bold;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        li {
            margin-bottom: 5px;
        }

        .expense-sum {
            font-weight: bold;
            margin-top: 10px;
        }

        .total-expenses {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 4px;
        }

        .total-expenses span {
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .container {
                border-radius: 0;
            }

            th,
            td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Events Report</h2>
            <p class="date-range">From: {{ \Carbon\Carbon::parse($startMonth)->format('F Y') }} To:
                {{ \Carbon\Carbon::parse($endMonth)->format('F Y') }}</p>
        </div>

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
                            <th>Budget</th>
                            <th>Expenses</th>
                            <th>Liquidated</th>
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
                                        <div class="expense-sum">
                                            Total: {{ number_format($event->expenses->sum('expense_amount'), 2) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($event->reciept)
                                        ✔
                                    @else
                                        —
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @php
                $totalExpenses = $events
                    ->flatMap(function ($event) {
                        return $event->expenses;
                    })
                    ->sum('expense_amount');
            @endphp

            <div class="total-expenses">
                Total Expenses: <span>{{ number_format($totalExpenses, 2) }}</span>
            </div>
        @endif
    </div>

    <script>
        window.print();
    </script>
</body>

</html>
