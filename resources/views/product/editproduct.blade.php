<!-- Existing HTML Structure -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Edit Product</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/ai-1.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, dont include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li>
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
                    <li>
                        <a href="{{ url('report') }}">
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
                        <div class="navbar-toggle"></div>
                    </div>
                    @if (Session::has('loginUser'))
                        @php
                            $user = app('App\Http\Controllers\AuthController')->getUserAccount(request());
                        @endphp
                        <li class="nav-item d-flex align-items-center">
                            <span style="margin-right: 10px;">{{ $user->username }}</span>
                            <a class="nav-link btn btn-danger btn-sm" href="{{ url('logout') }}"
                                style="color: white; padding: 5px 10px; font-size: 14px; border-radius: 15px;">Logout</a>
                        </li>
                    @endif
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-lg p-3 mb-5 bg-white rounded"
                            style="border-radius: 20px; border-color: #007bff; border-width: 2px;">
                            <div class="card-header"
                                style="background-color: #007bff; color: white; border-top-left-radius: 18px; border-top-right-radius: 18px;">
                                <h4 class="card-title" style="color: white;">แก้ไขสินค้า</h4>
                            </div>
                            <div class="card-body" style="background-color: #f8f9fa;">
                                @if (Session::has('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                                @if (Session::has('fail'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ Session::get('fail') }}
                                    </div>
                                @endif
                                <form action="{{ route('product.update') }}" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">

                                    <!-- ชื่อสินค้า -->
                                    <div class="form-group mb-3">
                                        <label for="name">ชื่อสินค้า</label>
                                        <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                                        <span class="text-danger">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <!-- ราคา -->
                                    <div class="form-group mb-3">
                                        <label for="price">ราคา</label>
                                        <input type="text" name="price" class="form-control" value="{{ $product->price }}">
                                        <span class="text-danger">
                                            @error('price')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <!-- รูปสินค้า -->
                                    <div class="form-group mb-3">
                                        <label for="image">แก้ไขรูปสินค้า</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="imageInput" accept="image/*" onchange="loadImage(event)">
                                            <label class="custom-file-label" for="imageInput" id="fileNameLabel">เลือกไฟล์รูปภาพใหม่ (ถ้ามี)</label>
                                            <span class="text-danger">
                                                @error('image')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <!-- แสดงรูปภาพปัจจุบัน -->
                                        <div class="mt-3" id="currentImageContainer">
                                            <p>รูปภาพปัจจุบัน:</p>
                                            @if ($product->image)
                                                <img src="{{ url('/' . $product->image) }}" alt="รูปสินค้า"
                                                    style="width: 30%; height: 30%; object-fit: cover;">
                                            @else
                                                <p>ไม่มีรูปภาพ</p>
                                            @endif
                                        </div>

                                        <!-- แสดงตัวอย่างรูปภาพใหม่ -->
                                        <div class="mt-3">
                                            <img id="imagePreview" src="#" alt="Preview รูปภาพใหม่"
                                                style="display: none; width: 30%; height: 30%; object-fit: cover; border-radius: 10px;">
                                        </div>
                                    </div>

                                    <script>
                                        function loadImage(event) {
                                            const imagePreview = document.getElementById('imagePreview');
                                            const fileNameLabel = document.getElementById('fileNameLabel');
                                            const currentImageContainer = document.getElementById('currentImageContainer');

                                            if (event.target.files && event.target.files[0]) {
                                                const reader = new FileReader();
                                                reader.onload = function(e) {
                                                    imagePreview.src = e.target.result;
                                                    imagePreview.style.display = 'block';

                                                    // Hide current image container when new image is selected
                                                    currentImageContainer.style.display = 'none';
                                                };
                                                reader.readAsDataURL(event.target.files[0]);

                                                // อัปเดตชื่อไฟล์ใน label
                                                fileNameLabel.textContent = event.target.files[0].name;
                                            }
                                        }
                                    </script>

                            </div>

                            <!-- ปุ่มบันทึกการเปลี่ยนแปลง -->
                            <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
    <!-- Paper Dashboard DEMO methods, dont include it in your project! -->
    <script src="../assets/demo/demo.js"></script>
    <script>
        $(document).ready(function() {
            // Demo.js methods are used for notifications, etc.
            demo.initDashboardPageCharts();
        });
    </script>
</body>

</html>
