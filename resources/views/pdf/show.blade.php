<!DOCTYPE html>
<html>
<head>
    <title>Report Page</title>
</head>
<body>
    <h1>Report</h1>
    <p>{{ $data['message'] }}</p>
    <a href="{{ route('report.download') }}">Download PDF</a>
</body>
</html>
