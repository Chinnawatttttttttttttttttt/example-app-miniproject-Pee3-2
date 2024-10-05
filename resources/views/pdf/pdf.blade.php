<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            color: #333;
        }
        .report-header, .report-section {
            margin-bottom: 20px;
        }
        .report-header h1, .report-header p, .report-section h2 {
            margin: 0;
            padding: 0;
        }
        .report-header h1 {
            color: #444;
            border-bottom: 3px solid #666;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .report-header p, .report-section h2 {
            margin-top: 10px;
            font-size: 18px;
        }
        .report-section h2 {
            color: #555;
            margin-bottom: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        li {
            background-color: #f9f9f9;
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h1>{{ $title }}</h1>
        <p>Date: {{ $date }}</p>
    </div>
    <div class="report-section">
        <h2>Total Sales</h2>
        <p>{{ $totalSales }}</p>
    </div>
    <div class="report-section">
        <h2>Counts by Product</h2>
        <ul>
            @foreach ($counts as $name => $quantity)
                <li>{{ $name }}: {{ $quantity }}</li>
            @endforeach
        </ul>
    </div>
</body>
</html>
