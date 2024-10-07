<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        จัดการสินค้า
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project' -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="active ">
                        <a href="{{ url('all-product') }}">
                            <i class="fas fa-box"></i>
                            <p>จัดการสินค้า</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sales.summary') }}">
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

                    </div>
                    @if (Session::has('loginUser'))
                        @php
                            $user = app('App\Http\Controllers\AuthController')->getUserAccount(request());
                        @endphp
                        <li class="nav-item d-flex align-items-center">
                            <span style="margin-right: 10px;">{{ $user->username }}</span>
                            <a class="nav-link btn btn-danger btn-sm" href="{{ url('logout') }}" style="color: white; padding: 5px 10px; font-size: 14px; border-radius: 15px;">ออกจากระบบ</a>
                        </li>
                    @endif

                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> รายการสินค้า</h4>
                                <a class="btn btn-success" href="/add-product">เพิ่มสินค้า</a>
                                <button class="btn btn-primary" id="generate-pdf">
                                    <i class="fas fa-print"></i>
                                </button>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-primary text-center">
                                            <th>ลำดับ</th>
                                            <th>รูปสินค้า</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>ราคา</th>
                                            <th>แก้ไขสินค้า</th>
                                            <th>ลบสินค้า</th>
                                        </thead>
                                        <tbody class="text-center">
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><img src="{{ $product->image }}" width="50px"></td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->price }}</td>
                                                    <td><a href="/edit-product/{{ $product->id }}"
                                                            class="btn btn-warning">แก้ไข</a></td>
                                                    <td>
                                                        <form action="{{ route('store.delete', $product->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-xs btn-danger btn-flat show_confirm"
                                                                data-toggle="tooltip" title="Delete">
                                                                ลบสินค้า
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
    <script src="../assets/demo/demo.js"></script>

    <script>
        document.getElementById('generate-pdf').addEventListener('click', function() {
            // Fetch the content from the report.product route
            fetch("{{ route('report.product') }}")
                .then(response => response.text()) // Fetch HTML as text
                .then(data => {
                    // Convert the fetched HTML into a DOM object
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const element = doc.querySelector('.container'); // Get the content (change .container to .content if needed)

                    // Add CSS to set the font back to the template's original font
                    const style = document.createElement('style');
                    style.innerHTML = `
                        * {
                            font-family: 'Open Sans', Arial, sans-serif !important;
                            color: black !important;
                            background-color: white !important;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        table, th, td {
                            border: 1px solid black;
                        }
                        th, td {
                            padding: 5px;
                            text-align: center;
                        }
                        img {
                            max-width: 100px;
                            height: auto;
                        }
                        /* ปรับความกว้างของคอลัมน์ ID และ Image */
                        th.id-column, td.id-column {
                            width: 5%;
                        }
                        th.image-column, td.image-column {
                            width: 10%;
                        }
                    `;
                    element.appendChild(style);

                    // Configure options for generating the PDF
                    var opt = {
                        margin: 0.5,
                        filename: 'Product_Report.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                    };

                    // Generate the PDF and open it in a new window
                    html2pdf().set(opt).from(element).output('blob').then(function(pdfBlob) {
                        var pdfUrl = URL.createObjectURL(pdfBlob);
                        var pdfWindow = window.open();
                        pdfWindow.location.href = pdfUrl;
                    });
                })
                .catch(error => console.error('Error fetching report data:', error));
        });
    </script>
</body>

</html>
