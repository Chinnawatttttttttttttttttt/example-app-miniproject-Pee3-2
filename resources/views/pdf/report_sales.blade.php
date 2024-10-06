<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
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
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #95a5a6;
        }
    </style>
</head>
<body class="container">
    <div class="report-header">
        <h1>รายงานยอดขาย</h1>
        <p>Date: {{ $date }}</p>
    </div>

    <div class="report-section">
        <h2>ยอดขายรวม</h2>
        <p>{{ number_format($totalSales, 2) }} บาท</p>
    </div>

    <div class="report-section">
        <h2>จำนวนที่ขายได้ตามสินค้า</h2>
        <ul>
            @foreach ($counts as $item)
                <li>{{ $item->name }} : {{ $item->total_quantity }} ชิ้น</li>
            @endforeach
        </ul>
    </div>

    <div class="footer">
        <p>รายงานนี้ถูกสร้างขึ้นในระบบเมื่อวันที่ {{ $date }}</p>
    </div>
</body>
</html>
