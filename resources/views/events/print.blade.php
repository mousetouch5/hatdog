

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }

        .sub-header {
            font-size: 16px;
            color: #555;
            margin-top: 5px;
        }

        .content p {
            margin: 5px 0;
            font-size: 14px;
        }

        .text-muted {
            color: gray;
            font-style: italic;
        }

        ul {
            padding-left: 20px;
            margin-top: 10px;
        }

        li {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .expense-amount {
            font-weight: bold;
            color: #d9534f;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }

        @media print {
            body {
                padding: 0;
            }

            .container {
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ $event->eventName }}</h1>
            <p class="sub-header">{{ $event->eventType }} - {{ \Carbon\Carbon::parse($event->eventDate)->format('F Y') }}</p>
        </div>
        <div class="content">
            <p><strong>Description:</strong> {{ $event->eventDescription }}</p>
            <p><strong>Location:</strong> {{ $event->eventLocation }}</p>
            <p><strong>Organizer:</strong> {{ $event->organizer }}</p>
            <p><strong>Total Budget:</strong> {{ number_format($total_event_budget, 2) }}</p>
            <p><strong>Total Expenses:</strong> {{ number_format($total_expense, 2) }}</p>
            <p><strong>Total Refunded:</strong> {{ number_format($total_refunded, 2) }}</p>
            <p><strong>Total To Be Reimbursed:</strong> {{ number_format($total_to_be_reimbursed, 2) }}</p>

            @if ($event->expenses->isEmpty())
                <p class="text-muted">No expenses recorded.</p>
            @else
                <ul>
                    @foreach ($event->expenses as $expense)
                        <li>
                            <strong>{{ $expense->expense_description }}:</strong>
                            <span class="expense-amount">{{ number_format($expense->expense_amount, 2) }}</span>
                            (Qty: {{ number_format($expense->quantity_amount, 0) }})
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</body>

</html>

<script>
    window.print();
</script>

