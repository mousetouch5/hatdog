<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Transaction</title>
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
            margin-bottom: 20px;
            /* Add margin to separate from button */
        }

        .transaction-details th,
        .transaction-details td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .transaction-details th {
            background-color: #f4f4f4;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .receipt-image {
            display: block;
            margin: 10px auto;
            /* Center the image */
            max-width: 100%;
            /* Responsive image */
            height: auto;
            /* Maintain aspect ratio */
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
                <th>Money Spent</th>
                <td>${{ number_format($transaction->money_spent, 2) }}</td>
            </tr>
            <tr>
                <th>Received By</th>
                <td>{{ $transaction->receive_by }}</td> <!-- Corrected spelling -->
            </tr>
            <tr>
                <th>Receipt</th> <!-- Corrected spelling -->
                <td>
                    <!-- Ensure the receipt path is valid -->
                    <img src="{{ asset('storage/' . $transaction->reciept) }}" alt="Receipt Image" class="receipt-image">
            </tr>
        </table>

    </div>

</body>

</html>

<script>
    window.print();
</script>
