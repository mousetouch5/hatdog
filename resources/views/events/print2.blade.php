<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Transaction</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .transaction-details {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .transaction-details th,
        .transaction-details td {
            padding: 15px;
            text-align: left;
        }

        .transaction-details th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
        }

        .transaction-details tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .transaction-details tr:hover {
            background-color: #f1f1f1;
        }

        .receipt-image {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        @media print {
            body {
                background-color: #ffffff;
            }

            .container {
                box-shadow: none;
                padding: 0;
            }

            .transaction-details {
                border: 1px solid #e0e0e0;
            }

            .transaction-details th {
                background-color: #f1f1f1;
                color: #333;
            }
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
                <td>{{ number_format($transaction->budget, 2) }}</td>
            </tr>
            <tr>
                <th>Received By</th>
                <td>{{ $transaction->recieveBy->name }}</td>
            </tr>
        </table>

        <h2>Receipt</h2>
        <img src="{{ asset('storage/' . $transaction->reciept) }}" alt="Receipt Image" class="receipt-image">
    </div>

    <script>
        window.print();
    </script>
</body>

</html>
