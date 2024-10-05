<!--
    =========================================================
    * Paper Dashboard 2 - v2.0.1
    =========================================================

    * Product Page: https://www.creative-tim.com/product/paper-dashboard-2
    * Copyright 2020 Creative Tim (https://www.creative-tim.com)

    Coded by www.creative-tim.com

     =========================================================

    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Home
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/ai-2.css') }}">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project' -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="white" data-active-color="danger">

            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="active ">
                        <a href="{{ url('homee') }}">
                            <i class="fas fa-home"></i>
                            <p>หน้าหลัก</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('reporte') }}">
                            <i class="fas fa-chart-bar"></i>
                            <p>สรุปการขาย</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">

                        </div>
                        <a class="navbar-brand" href="javascript:;">หน้าหลัก</a>
                    </div>
                    @if (Session::has('loginUser'))
                        @php
                            $user = app('App\Http\Controllers\AuthController')->getUserAccount(request());
                        @endphp
                        <li class="nav-item d-flex align-items-center">
                            <span style="margin-right: 10px;">{{ $user->username }}</span>
                            <a class="nav-link btn btn-danger btn-sm" href="{{ url('logout') }}" style="color: white; padding: 5px 10px; font-size: 14px; border-radius: 15px;">Logout</a>
                        </li>
                    @endif

                </div>
            </nav>

            <!-- End Navbar -->
            <div class="content">
                <div class="row">
                    @foreach ($products as $item)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="fas fa-ice-cream icon-ice-cream"></i>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const colors = [
                                                            '#e74c3c', '#3498db', '#2ecc71', '#f1c40f', '#9b59b6', '#e67e22', '#1abc9c', '#34495e',
                                                            '#95a5a6', '#d35400', '#c0392b', '#8e44ad', '#16a085', '#27ae60', '#2980b9', '#2c3e50',
                                                            '#f39c12', '#7f8c8d'
                                                        ];
                                                        const icons = document.querySelectorAll('.icon-ice-cream');
                                                        icons.forEach((icon, index) => {
                                                            icon.style.color = colors[index % colors.length];
                                                        });
                                                    });
                                                </script>

                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <h7 class="card-title" style="margin:0;">รส: {{ $item->name }}
                                                </h7>
                                                <p class="card-text" style="font-size:20px;">ราคา: {{ $item->price }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <hr>
                                    <div class="quantity-controls">
                                        <button class="decrease-quantity"
                                            onclick="changeQuantity('{{ $item->id }}', -1)">-</button>
                                        <span id="quantity-{{ $item->id }}">0</span>
                                        <button class="increase-quantity"
                                            onclick="changeQuantity('{{ $item->id }}', 1)">+</button>
                                        <script>
                                            function changeQuantity(productId, change) {
                                                // Find the quantity span
                                                const quantitySpan = document.getElementById(`quantity-${productId}`);
                                                // Parse current quantity, increment/decrement, and update
                                                let quantity = parseInt(quantitySpan.innerText);
                                                quantity += change;
                                                // Prevent negative values
                                                quantity = quantity < 0 ? 0 : quantity;
                                                // Update the display
                                                quantitySpan.innerText = quantity;
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="container mt-6" style="max-width: none;">
                    <div class="card" style="width: 1600px;">
                        <div class="card-header">
                            <h5>รายการสินค้า</h5>
                        </div>

                        <div class="card-body">
                            <button id="showDataButton" class="btn btn-primary">Show Data</button>
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ชื่อรส</th>
                                        <th>ราคา</th>
                                        <th>จำนวน</th>
                                        <th>ราคาสินค้า</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <!-- Data rows will be inserted here -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">รวมราคาทั้งหมด</th>
                                        <th id="overallTotal">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <button id="submitDataButton" class="btn btn-success mt-3">Submit Data</button>
                            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                document.getElementById('submitDataButton').addEventListener('click', function(e) {
                                    e.preventDefault(); // ป้องกันการส่งฟอร์มถ้ามี
                                    Swal.fire({
                                        title: 'ขายสำเร็จ!',
                                        icon: 'success',
                                        confirmButtonText: 'ตกลง'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload(); // รีเฟรชหน้าจอ
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById('showDataButton').addEventListener('click', function() {
                        const data = @json($products); // Convert your PHP variable to a JSON object
                        const tableBody = document.getElementById('tableBody');
                        tableBody.innerHTML = ''; // Clear existing rows

                        let overallTotal = 0; // Initialize overall total

                        data.forEach(product => {
                            const quantityElement = document.getElementById(`quantity-${product.id}`);
                            let quantity = quantityElement ? parseInt(quantityElement.innerText, 10) :
                                0; // Parse as integer, default to 0 if not found
                            let total = product.price * quantity; // Calculate total for this product

                            // Only append rows for products with quantity > 0
                            if (quantity > 0) {
                                const row = `<tr>
                                                    <td>${product.id}</td>
                                                    <td>${product.name}</td>
                                                    <td>${product.price}</td>
                                                    <td>${quantity}</td>
                                                    <td>${total}</td>
                                                 </tr>`;
                                tableBody.innerHTML += row;
                                overallTotal += total; // Add to overall total
                            }
                        });

                        // Update the overall total in the table footer
                        document.getElementById('overallTotal').innerText = overallTotal.toFixed(
                            2); // Assuming price is a floating point number
                    });

                    document.getElementById('submitDataButton').addEventListener('click', function() {
                        const data = @json($products); // Assuming $products is available in your blade template
                        let items = [];

                        data.forEach(product => {
                            const quantityElement = document.getElementById(`quantity-${product.id}`);
                            let quantity = quantityElement ? parseInt(quantityElement.innerText, 10) : 0;

                            if (quantity > 0) {
                                items.push({
                                    id: product.id,
                                    name: product.name,
                                    quantity: quantity,
                                    total: product.price * quantity,
                                });
                            }
                        });

                        // Calculate overallTotal
                        let overallTotal = items.reduce((acc, item) => acc + item.total, 0);

                        // Prepare data to send
                        let formData = {
                            items: items,
                            overallTotal: overallTotal,
                        };

                        // Send data via AJAX
                        fetch('/submit-data', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content')
                                },
                                body: JSON.stringify(formData)
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Success:', data);
                                // Handle success response
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                // Handle error here
                            });
                    });
                </script>

            </div>
        </div>

        <!--   Core JS Files   --

            <script src="../assets/js/core/jquery.min.js"></script>
            <script src="../assets/js/core/popper.min.js"></script>
            <script src="../assets/js/core/bootstrap.min.js"></script>
            <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>


            <script src="../assets/js/plugins/chartjs.min.js"></script>
            <!--  Notifications Plugin    -->
        <script src="../assets/js/plugins/bootstrap-notify.js"></script>
        <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project' -->
        <script src="../assets/demo/demo.js"></script>

</body>

</html>
