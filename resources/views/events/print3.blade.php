<!-- resources/views/transactions/download_pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .transaction-details {
            width: 100%;
            border-collapse: collapse;
        }

        .transaction-details th,
        .transaction-details td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .transaction-details th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Transaction Details</h1>
        <table class="transaction-details">
            <tr>
                <th>Authorized Official</th>
                <td>{{ $transaction->authorizeOfficial ? $transaction->authorizeOfficial->name : 'No official assigned' }}
                </td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $transaction->description }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ \Carbon\Carbon::parse($transaction->date)->format('F Y') }}</td>
            </tr>
            <tr>
                <th>Budget</th>
                <td>${{ number_format($transaction->budget, 2) }}</td>
            </tr>
            <tr>
                <th>Received By</th>
                <td>{{ $transaction->recieve_by }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
