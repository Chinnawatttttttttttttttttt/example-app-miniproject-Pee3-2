<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Home </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!-- Fonts and icons -->
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

    <style>
        /* เพิ่มสไตล์สำหรับปุ่มลอย */
        #floatingCartButton {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #f44336;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            cursor: pointer;
        }

        /* เมื่อ hover ให้เปลี่ยนสี */
        #floatingCartButton:hover {
            background-color: #e53935;
        }

        /* ข้อความสั่งซื้อสินค้า */
        #floatingCartButtonText {
            position: fixed;
            bottom: 90px;
            right: 30px;
            background-color: #f44336;
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
            z-index: 999;
        }
    </style>
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
                            <a class="nav-link btn btn-danger btn-sm" href="{{ url('logout') }}"
                                style="color: white; padding: 5px 10px; font-size: 14px; border-radius: 15px;">Logout</a>
                        </li>
                    @endif

                </div>
            </nav>
            <!-- End Navbar -->

            <!-- Cart Product -->
            <div class="content">
                <div class="row">
                    @foreach ($products as $item)
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="text-center">
                                        <!-- Display product image with centered layout and a clean border -->
                                        <img src="{{ url('/' . $item->image) }}" alt="{{ $item->name }}"
                                             class="img-fluid rounded mx-auto d-block"
                                             style="max-width: 120px; height: 120px; object-fit: cover; border: 1px solid #ddd; padding: 5px;">
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="card-title text-center font-weight-bold" style="font-size: 1rem;">{{ $item->name }}</h6>
                                        <p class="text-center text-muted" style="font-size: 18px;">ราคา: ฿{{ number_format($item->price, 2) }}</p>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <!-- Quantity controls with a more modern look -->
                                            <button class="btn btn-outline-secondary btn-sm px-3 decrease-quantity"
                                                    onclick="changeQuantity('{{ $item->id }}', -1)">-</button>
                                            <span id="quantity-{{ $item->id }}" class="mx-3" style="font-size: 18px;">0</span>
                                            <button class="btn btn-outline-secondary btn-sm px-3 increase-quantity"
                                                    onclick="changeQuantity('{{ $item->id }}', 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- END Cart Product -->

            <!-- Floating Cart Button -->
            <div id="floatingCartButton" data-bs-toggle="modal" data-bs-target="#cartModal">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div id="floatingCartButtonText">สั่งซื้อสินค้า</div>

            <!-- Cart Items Modal -->
            <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cartModalLabel">สินค้าที่อยู่ในตะกร้า</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul id="cartItemsList"></ul>
                        </div>
                        <div class="modal-footer">
                            <button id="submitDataButton" class="btn btn-primary">ยืนยันการสั่งซื้อ</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Receipt Modal -->
            <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="receiptModalLabel">ใบเสร็จ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>วัน: <span id="receiptDate"></span></p>
                            <p>ชื่อผู้สั่ง: <span id="customerName"></span></p>
                            <h3>รายการสินค้า:</h3>
                            <ul id="receiptItemsList"></ul>
                            <p>รวมทั้งหมด: <span id="overallTotalReceipt"></span></p>
                            <canvas id="receiptCanvas" style="display: none;"></canvas>
                        </div>
                        <div class="modal-footer">
                            <button id="downloadReceiptButton" class="btn btn-primary">ดาวน์โหลดใบเสร็จ</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const cart = {};

                function changeQuantity(productId, change) {
                    const quantitySpan = document.getElementById(`quantity-${productId}`);
                    let quantity = parseInt(quantitySpan.innerText);
                    quantity += change;

                    if (quantity < 0) quantity = 0;
                    quantitySpan.innerText = quantity;

                    if (quantity === 0) delete cart[productId];
                    else cart[productId] = quantity;
                }

                // ฟังก์ชันสำหรับแสดงสินค้าที่อยู่ในตะกร้า
                document.getElementById('cartModal').addEventListener('show.bs.modal', function () {
                    const cartItemsList = document.getElementById('cartItemsList');
                    cartItemsList.innerHTML = ''; // ล้างรายการก่อนแสดงใหม่

                    if (Object.keys(cart).length === 0) {
                        cartItemsList.innerHTML = '<li>ไม่มีสินค้าที่อยู่ในตะกร้า</li>';
                    } else {
                        for (const productId in cart) {
                            const product = @json($products).find(item => item.id == productId);
                            if (product && cart[productId] > 0) {
                                const listItem = document.createElement('li');
                                listItem.innerHTML = `${product.name} - จำนวน: ${cart[productId]} - ราคา: ${product.price * cart[productId]} บาท`;
                                cartItemsList.appendChild(listItem);
                            }
                        }
                    }
                });

                document.getElementById('submitDataButton').addEventListener('click', function(e) {
                    e.preventDefault();

                    // Fetch the cart items from the displayed data
                    const data = @json($products); // Laravel blade syntax for passing PHP data to JavaScript
                    let items = [];

                    data.forEach(product => {
                        const quantityElement = document.getElementById(`quantity-${product.id}`);
                        let quantity = quantityElement ? parseInt(quantityElement.innerText, 10) : 0;

                        if (quantity > 0) {
                            items.push({
                                id: product.id,
                                name: product.name,
                                quantity: quantity,
                                price: product.price,
                                total: product.price * quantity,
                            });
                        }
                    });

                    let overallTotal = items.reduce((acc, item) => acc + item.total, 0);

                    let formData = {
                        items: items,
                        overallTotal: overallTotal,
                    };

                    // Send form data via AJAX to the server
                    fetch('/submit-data', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(formData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success alert
                                Swal.fire({
                                    title: 'ซื้อสินค้าเรียบร้อย!',
                                    icon: 'success',
                                    confirmButtonText: 'ตกลง'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Populate receipt details
                                        document.getElementById("receiptDate").innerText = new Date().toLocaleDateString();
                                        document.getElementById("customerName").innerText = 'ชื่อผู้ใช้'; // Replace with actual user name if available
                                        const receiptItemsList = document.getElementById("receiptItemsList");
                                        receiptItemsList.innerHTML = ''; // Clear previous items

                                        items.forEach(item => {
                                            const listItem = document.createElement('li');
                                            listItem.innerText = `${item.name} (จำนวน: ${item.quantity} ราคาต่อหน่วย: ${item.price} บาท) ราคารวม: ${item.total} บาท`;
                                            receiptItemsList.appendChild(listItem);
                                        });

                                        document.getElementById("overallTotalReceipt").innerText = overallTotal + ' บาท';

                                        // Show the modal
                                        const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
                                        receiptModal.show();

                                        // Wait for the modal to be fully shown before downloading
                                        document.getElementById('downloadReceiptButton').onclick = function () {
                                            // รอให้ Modal แสดงผลอย่างสมบูรณ์
                                            setTimeout(() => {
                                                const receiptModalContent = document.querySelector('#receiptModal .modal-content'); // จับภาพเฉพาะเนื้อหาใน Modal

                                                html2canvas(receiptModalContent).then(canvas => {
                                                    const link = document.createElement('a');
                                                    link.download = 'ใบเสร็จ.png';  // ชื่อไฟล์ใบเสร็จ
                                                    link.href = canvas.toDataURL('image/png');  // แปลงเป็นภาพ PNG
                                                    link.click();  // ดาวน์โหลดรูปภาพ
                                                }).catch(error => {
                                                    console.error('Error capturing receipt:', error);
                                                    Swal.fire({
                                                        title: 'เกิดข้อผิดพลาด!',
                                                        text: 'ไม่สามารถจับภาพใบเสร็จได้',
                                                        icon: 'error',
                                                        confirmButtonText: 'ตกลง'
                                                    });
                                                });
                                            }, 1000);  // รอเวลา 1 วินาทีเพื่อให้มั่นใจว่า Modal แสดงผลครบถ้วน
                                        };

                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'ตกลง'
                                });
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'เกิดข้อผิดพลาด!',
                                text: 'ไม่สามารถบันทึกการสั่งซื้อได้',
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        });
                });

            </script>

            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.0.0-alpha.12/html2canvas.min.js"></script>

</body>

</html>
