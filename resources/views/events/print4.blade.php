<!-- resources/views/transactions/print_all.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Transactions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .transaction-table {
            width: 100%;
            border-collapse: collapse;
        }

        .transaction-table th,
        .transaction-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .transaction-table th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>All Transactions</h1>
    <table class="transaction-table">
        <thead>
            <tr>
                <th>Authorized Official</th>
                <th>Description</th>
                <th>Date</th>
                <th>Budget</th>
                <th>Received By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $trs)
                <tr>
                    <td>{{ $trs->authorizeOfficial ? $trs->authorizeOfficial->name : 'No official assigned' }}</td>
                    <td>{{ $trs->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($trs->date)->format('F Y') }}</td>
                    <td>{{ $trs->budget }}</td>
                    <td>{{ $trs->recieve_by }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.print();
    </script>
</body>

</html>
