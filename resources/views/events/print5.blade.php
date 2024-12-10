<!-- resources/views/survey/print.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Survey Response</title>
    <style>
        /* Add basic print styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Survey Response Details</h1>
    <p><strong>User:</strong> {{ $response->user->name }}</p>
    <p><strong>Participation:</strong> {{ $response->participation }}</p>

    <h3>Event Types Answer:</h3>
    <ul>
        @foreach ($response->event_types as $event)
            <li>{{ $event }}</li>
        @endforeach
    </ul>

    <h3>Event Information:</h3>
    <ul>
        @foreach ($response->event_info as $info)
            <li>{{ $info }}</li>
        @endforeach
    </ul>

    <h3>Impact:</h3>
    <ul>
        @foreach ($response->impact as $impact)
            <li>{{ $impact }}</li>
        @endforeach
    </ul>


    <script>
        window.print();
    </script>
</body>

</html>
