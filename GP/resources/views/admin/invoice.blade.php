<!-- resources/views/pdf/invoice.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #164863;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Invoice</h1>
        <p><strong>Student Name:</strong> {{ $payment->student->name }}</p>
        <p><strong>IC Number:</strong> {{ $payment->student->ic }}</p>
        <p><strong>Course:</strong> {{ $payment->course->name }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->toFormattedDateString() }}</p>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $payment->course->name }}</td>
                    <td>${{ $payment->total_payment }}</td>
                </tr>
                <tr>
                    <td class="total">Total</td>
                    <td class="total">${{ $payment->total_payment }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
