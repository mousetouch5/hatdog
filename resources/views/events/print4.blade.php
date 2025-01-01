<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Transactions</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 1200px;
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

        .transaction-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .transaction-table th,
        .transaction-table td {
            padding: 12px 15px;
            text-align: left;
        }

        .transaction-table th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
        }

        .transaction-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .transaction-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .transaction-table td {
            border-bottom: 1px solid #e0e0e0;
        }

        .transaction-table tbody tr:last-child td {
            border-bottom: none;
        }

        @media print {
            body {
                background-color: #ffffff;
            }

            .container {
                box-shadow: none;
                padding: 0;
            }

            .transaction-table {
                border: 1px solid #e0e0e0;
            }

            .transaction-table th {
                background-color: #f1f1f1;
                color: #333;
            }
        }
    </style>
</head>

<body>
    <div class="container">
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
                        <td>{{ number_format($trs->budget, 2) }}</td>
                        <td>{{ $trs->recieveBy->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
