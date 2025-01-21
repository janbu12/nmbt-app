<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        /* Reset some default browser styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        h2 {
            font-size: 24px;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #007bff;
        }

        h3 {
            font-size: 20px;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        p {
            margin-bottom: 10px;
            font-size: 16px;
        }

        strong {
            font-weight: bold;
            color: #007bff;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 24px;
            }

            h2 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }

            .table th,
            .table td {
                padding: 10px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Peminjaman</h1>
        <div>
            <h3>Summary</h3>
            <p>Total Product Quantity Rented: <strong>{{ $quantityRentTotal }}</strong></p>
            <p>Total Rents: <strong>{{ $totalBorrowed }}</strong></p>
            <p>Total Ongoing Rents: <strong>{{ $ongoingRent }}</strong></p>
            <p>Total Renting Rents: <strong>{{ $totalRenting }}</strong></p>
            <p>Total Done Rents: <strong>{{ $doneRents }}</strong></p>
            <p>Total Income: <strong>Rp. {{ number_format($totalIncome, 2, ',', '.') }}</strong></p>
        </div>
        <h2>1. Income</h2>
        <h3>- By Day</h3>
        <div class="table-responsive mt-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Income</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1
                    @endphp
                    @foreach ($incomeByDay as $date => $income)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $date }}</td>
                            <td>Rp. {{ number_format($income, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h3>- By Month</h3>
        <div class="table-responsive mt-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Income</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1
                    @endphp
                    @foreach ($incomeByMonth as $date => $income)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $date }}</td>
                            <td>Rp. {{ number_format($income, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2>2. Rents</h2>
        <h3>- By Day</h3>


        <h3>- By Month</h3>

        <div class="table-responsive mt-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Harga</th>
                        <th>Terjual</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>Rp. {{ number_format($item->product->price, 2, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp. {{ number_format(($item->quantity * $item->product->price), 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
