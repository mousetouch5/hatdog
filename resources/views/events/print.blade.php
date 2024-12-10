<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ $event->eventName }}</h1>
            <p>{{ $event->eventType }} - {{ \Carbon\Carbon::parse($event->eventDate)->format('F Y') }}</p>
        </div>
        <div class="content">
            <p><strong>Description:</strong> {{ $event->eventDescription }}</p>
            <p><strong>Location:</strong> {{ $event->eventLocation }}</p>
            <p><strong>Organizer:</strong> {{ $event->organizer }}</p>
            <p><strong>Total Budget:</strong> {{ number_format($total_event_budget, 2) }}</p>
            <p><strong>Total Expenses:</strong> {{ number_format($total_expense, 2) }}</p>
            <p><strong>Total Refunded:</strong> {{ number_format($total_refunded, 2) }}</p>
            <p><strong>Total To Be Reimbursed:</strong> {{ number_format($total_to_be_reimbursed, 2) }}</p>
        </div>
        <div class="footer">
            <button onclick="window.print()">Print</button>
        </div>
    </div>
</body>

</html>
