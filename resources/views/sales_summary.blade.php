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
        Report
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
    <link href="../assets/css/pdf.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project' -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li >
                        <a href="{{ url('home') }}">
                            <i class="fas fa-home"></i>
                            <p>หน้าหลัก</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('all-product') }}">
                            <i class="fas fa-ice-cream"></i>
                            <p>สินค้า</p>
                        </a>
                    </li>
                    <li class="active ">
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
                        <a class="navbar-brand" href="javascript:;">สรุปการขาย</a>
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
                    @foreach ($counts as $name => $quantity)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="fas fa-ice-cream icon-ice-cream"></i>
                                            </div>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const colors = [
                                                        '#e74c3c','#3498db','#2ecc71','#f1c40f','#9b59b6','#e67e22','#1abc9c','#34495e','#95a5a6','#d35400','#c0392b','#8e44ad','#16a085','#27ae60','#2980b9','#2c3e50','#f39c12','#7f8c8d'
                                                    ];
                                                    const icons = document.querySelectorAll('.icon-ice-cream');
                                                    icons.forEach((icon, index) => {
                                                        icon.style.color = colors[index % colors.length];
                                                    });
                                                });
                                            </script>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <h7 class="card-title" style="margin:0;">รส: {{ $name }}</h7>
                                                <p class="card-text" style="font-size:20px;">จำนวนที่ขายได้:
                                                    {{ $quantity }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button id="showSalesReportButton" class="btn btn-primary">Show Sales Report</button>
                <div class="col-lg-12">
                    <div class="card card-stats">
                        <div class="card-body"
                            style="display: flex; align-items: center; justify-content: center; height: 120px;">
                            <div class="row">
                                <div class="col-12">
                                    <div class="numbers text-center">
                                        <p class="card-text" style="font-size:24px;">รวมยอดขายทั้งหมด:
                                            {{ $totalSales }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-6" style="max-width: none;">
                    <div class="card" style="width: 1560px;">
                        <div class="card-header">
                            <h5>กราฟแสดงการขาย</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="countsChart"></canvas>
                        </div>

                        <script>
                            // Prepare the data
                            var countsData = @json($counts);

                            // Extracting names and quantities
                            var names = Object.keys(countsData);
                            var quantities = Object.values(countsData);

                            // Define colors for the chart
                            var backgroundColors = [
                                'rgba(255, 99, 132, 0.2)', // pink soft
                                'rgba(54, 162, 235, 0.2)', // blue soft
                                'rgba(255, 206, 86, 0.2)', // yellow soft
                                'rgba(75, 192, 192, 0.2)', // green soft
                                'rgba(153, 102, 255, 0.2)', // purple soft
                                'rgba(255, 159, 64, 0.2)'  // orange soft
                            ];
                            var borderColors = [
                                'rgba(255, 99, 132, 1)', // pink strong
                                'rgba(54, 162, 235, 1)', // blue strong
                                'rgba(255, 206, 86, 1)', // yellow strong
                                'rgba(75, 192, 192, 1)', // green strong
                                'rgba(153, 102, 255, 1)', // purple strong
                                'rgba(255, 159, 64, 1)'  // orange strong
                            ];

                            // Setting up the chart
                            var ctx = document.getElementById('countsChart').getContext('2d');
                            var countsChart = new Chart(ctx, {
                                type: 'bar', // You can change this to 'line', 'pie', etc.
                                data: {
                                    labels: names,
                                    datasets: [{
                                        label: 'Quantities',
                                        data: quantities,
                                        backgroundColor: backgroundColors, // Use the defined colors
                                        borderColor: borderColors, // Use the defined colors
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('showSalesReportButton').addEventListener('click', function() {
                // Fetch content from the report.sales route
                fetch("{{ route('report.sales') }}")
                    .then(response => response.text()) // Get HTML as text
                    .then(data => {
                        // สร้าง DOM จาก HTML ที่ดึงมา
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(data, 'text/html');
                        const element = doc.querySelector('.container'); // ตรวจสอบว่ามีเนื้อหาที่ต้องการอยู่ใน container

                        // กำหนด CSS เพิ่มเติมถ้าจำเป็น
                        const style = document.createElement('style');
                        style.innerHTML = `
                            * {
                                font-family: 'Open Sans', Arial, sans-serif !important;
                                color: black !important;
                                background-color: white !important;
                            }
                            body {
                                font-family: 'Arial', sans-serif;
                                margin: 40px;
                                color: #333;
                                background-color: #f4f7fa;
                            }

                            .report-header {
                                text-align: center;
                                margin-bottom: 40px;
                            }

                            .report-header h1 {
                                color: #2c3e50;
                                font-size: 28px;
                                margin: 0;
                                padding-bottom: 10px;
                                border-bottom: 3px solid #2980b9;
                                display: inline-block;
                            }

                            .report-header p {
                                margin: 5px 0;
                                font-size: 16px;
                                color: #7f8c8d;
                            }

                            .report-section {
                                background-color: white;
                                padding: 20px;
                                border-radius: 8px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                margin-bottom: 30px;
                            }

                            .report-section h2 {
                                color: #2980b9;
                                font-size: 20px;
                                border-bottom: 2px solid #ecf0f1;
                                padding-bottom: 10px;
                                margin-bottom: 20px;
                            }

                            .report-section p {
                                font-size: 18px;
                                margin: 0;
                                color: #2c3e50;
                            }

                            ul {
                                list-style-type: none;
                                padding: 0;
                                margin: 0;
                            }

                            li {
                                background-color: #ecf0f1;
                                margin: 5px 0;
                                padding: 15px;
                                border: 1px solid #bdc3c7;
                                border-radius: 5px;
                                font-size: 18px;
                                color: #2c3e50;
                            }

                            .footer {
                                text-align: center;
                                margin-top: 30px;
                                font-size: 14px;
                                color: #95a5a6;
                            }
                        `;
                        element.appendChild(style); // ใส่ style เพิ่มเติม

                        // ตั้งค่า options สำหรับการสร้าง PDF
                        var opt = {
                            margin: 0.5,
                            filename: 'Sales_Report.pdf',
                            image: { type: 'jpeg', quality: 0.98 },
                            html2canvas: { scale: 2 },
                            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                        };

                        // สร้าง PDF และเปิดในหน้าต่างใหม่
                        html2pdf().set(opt).from(element).output('blob').then(function(pdfBlob) {
                            var pdfUrl = URL.createObjectURL(pdfBlob);
                            var pdfWindow = window.open();
                            pdfWindow.location.href = pdfUrl; // แสดง PDF ในหน้าต่างใหม่
                        });
                    })
                    .catch(error => console.error('Error fetching report data:', error));
            });
        </script>

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
