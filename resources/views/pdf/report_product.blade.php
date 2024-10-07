<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานสินค้า</title>
</head>
<body class="container">
    <h2>รางานสินค้า</h2>
    <table>
        <thead>
            <tr>
                <th class="id-column">ลำดับ</th>
                <th class="image-column">รูปสินค้า</th>
                <th>ชื่อสินค้า</th>
                <th>ราคา</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="id-column">{{ $loop->iteration }}</td>
                    <td class="image-column"><img src="{{ url('/' . $product->image) }}" alt="{{ $product->name }}" width="50px"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
