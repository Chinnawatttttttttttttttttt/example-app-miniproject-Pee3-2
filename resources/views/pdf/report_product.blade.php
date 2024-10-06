<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Report</title>
</head>
<body class="container">
    <h2>Product Report</h2>
    <table>
        <thead>
            <tr>
                <th class="id-column">ID</th>
                <th class="image-column">Image</th>
                <th>Name</th>
                <th>Price</th>
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
