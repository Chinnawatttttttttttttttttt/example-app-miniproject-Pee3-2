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
        /* ปุ่มลอยสำหรับตะกร้าสินค้า */
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

        #floatingCartButton:hover {
            background-color: #e53935;
        }

        /* ขนาดรูปภาพล็อกไว้ที่ 50px */
        .cart-item-details img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            /* รูปภาพจะถูกครอบตัดให้อยู่ในขนาดที่กำหนด */
            border-radius: 5px;
            /* มุมโค้งเล็กน้อย */
            border: 1px solid #ddd;
            padding: 2px;
            margin-right: 10px;
        }

        /* รูปแบบของรายการสินค้าในตะกร้า */
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .cart-item-details {
            display: flex;
            align-items: center;
        }

        /* การจัดการปุ่มใน modal */
        .modal-footer .btn-primary {
            background-color: #4CAF50;
            border: none;
            padding: 10px 5px;
            border-radius: 5px;
            font-size: 10px;
        }

        .modal-footer .btn-secondary {
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        /* ยอดรวม */
        .total-price {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        /* Receipt Modal CSS */
        .receipt-container {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .receipt-header {
            margin-bottom: 20px;
            text-align: center;
        }

        .receipt-header h4 {
            margin-bottom: 5px;
        }

        .receipt-header p {
            margin: 0;
            font-size: 14px;
            color: #777;
        }

        .list-group-item span {
            font-size: 14px;
        }

        hr {
            border-top: 1px solid #ddd;
        }

        .total-section p {
            font-size: 18px;
            font-weight: bold;
        }

        .modal-footer {
            border-top: none;
            justify-content: center;
        }

        .modal-footer .btn {
            width: 100px;
            font-size: 16px;
        }

        .text-danger {
            color: #e74c3c;
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
                            <i class="fas fa-shopping-cart"></i>
                            <p>สั่งซื้อสินค้า</p>
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
                        <a class="navbar-brand" href="javascript:;">สั่งซื้อสินค้า</a>
                    </div>
                    @if (Session::has('loginUser'))
                        @php
                            $user = app('App\Http\Controllers\AuthController')->getUserAccount(request());
                        @endphp
                        <li class="nav-item d-flex align-items-center">
                            <span style="margin-right: 10px;">{{ $user->username }}</span>
                            <a class="nav-link btn btn-danger btn-sm" href="{{ url('logout') }}"
                                style="color: white; padding: 5px 10px; font-size: 14px; border-radius: 15px;">ออกจากระบบ</a>
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
                                        <h6 class="card-title text-center font-weight-bold" style="font-size: 1rem;">
                                            {{ $item->name }}</h6>
                                        <p class="text-center text-muted" style="font-size: 18px;">ราคา:
                                            ฿{{ number_format($item->price, 2) }}</p>
                                        <div class="d-flex justify-content-center align-items-center mt-2">
                                            <!-- Quantity controls with a more modern look -->
                                            <button class="btn btn-outline-secondary btn-sm px-3 decrease-quantity"
                                                onclick="changeQuantity('{{ $item->id }}', -1)">-</button>
                                            <span id="quantity-{{ $item->id }}" class="mx-3"
                                                style="font-size: 18px;">0</span>
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
                <span id="cartItemCount" class="badge badge-pill badge-danger"
                    style="position: absolute; top: -10px; right: -10px; font-size: 0.9rem; display: none;">0</span>
            </div>

            <!-- Cart Items Modal -->
            <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <!-- ขยาย modal ให้ใหญ่ขึ้น -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cartModalLabel">สินค้าที่อยู่ในตะกร้า</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul id="cartItemsList" class="list-group">
                            </ul>
                        </div>
                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <div class="total-price">
                                <h5>ยอดรวม: <span id="totalPrice">0</span> บาท</h5> <!-- แสดงยอดรวม -->
                            </div>
                            <div>
                                <button id="submitDataButton" class="btn btn-primary">ยืนยันสั่งซื้อ</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Receipt Modal -->
            <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md"> <!-- ขยาย modal ขนาดกลาง -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="receiptModalLabel">ใบเสร็จ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="receipt-container">
                                <hr>
                                <p><strong>วันที่:</strong> <span id="receiptDate"></span></p>
                                <p><strong>ชื่อลูกค้า:</strong> <span id="customerName"></span></p>
                                <p><strong>ที่อยู่:</strong> <span id="customerAddress"></span></p>
                                <hr>
                                <h5>รายการสินค้า</h5>
                                <ul id="receiptItemsList" class="list-group"></ul>
                                <hr>
                                <div class="total-section">
                                    <p class="text-end"><strong>ยอดรวมทั้งหมด:</strong> <span id="overallTotalReceipt"
                                            class="text-danger"></span></p>
                                </div>
                                <div class="text-center">
                                    <p>ขอบคุณที่สั่งซื้อกับเรา!</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                id="closeReceiptButton">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>



            <script>
                const cart = {};
                let cartItemCount = 0; // ตัวนับจำนวนสินค้าในตะกร้า

                function updateCartItemCount() {
                    const cartItemCount = Object.keys(cart).length; // นับจำนวนสินค้าที่มีในตะกร้า
                    const cartItemCountElement = document.getElementById('cartItemCount');

                    if (cartItemCount > 0) {
                        cartItemCountElement.innerText = cartItemCount;
                        cartItemCountElement.style.display = 'block'; // แสดงจำนวนสินค้าในตะกร้า
                    } else {
                        cartItemCountElement.style.display = 'none'; // ซ่อนถ้าไม่มีสินค้าในตะกร้า
                    }
                }

                function changeQuantity(productId, change) {
                    const quantitySpan = document.getElementById(`quantity-${productId}`);
                    let quantity = parseInt(quantitySpan.innerText);
                    quantity += change;

                    if (quantity < 0) quantity = 0;
                    quantitySpan.innerText = quantity;

                    if (quantity === 0) {
                        delete cart[productId];
                    } else {
                        cart[productId] = quantity;
                    }

                    updateCartItemCount(); // อัปเดตจำนวนสินค้าที่มีในตะกร้าทุกครั้ง
                }

                document.getElementById('cartModal').addEventListener('show.bs.modal', function() {
                    const cartItemsList = document.getElementById('cartItemsList');
                    const totalPriceElement = document.getElementById('totalPrice');
                    let totalPrice = 0;
                    cartItemsList.innerHTML = ''; // ล้างรายการก่อนแสดงใหม่

                    if (Object.keys(cart).length === 0) {
                        cartItemsList.innerHTML = '<li class="list-group-item">ไม่มีสินค้าที่อยู่ในตะกร้า</li>';
                    } else {
                        for (const productId in cart) {
                            const product = @json($products).find(item => item.id == productId);
                            if (product && cart[productId] > 0) {
                                const totalItemPrice = product.price * cart[productId];
                                totalPrice += totalItemPrice;

                                const listItem = document.createElement('li');
                                listItem.classList.add('list-group-item');
                                listItem.innerHTML = `
                                    <div class="cart-item-details">
                                        <img src="${product.image}" alt="${product.name}">
                                        <span>${product.name}</span>
                                    </div>
                                    <div>
                                        <span>ราคา: ฿${product.price}</span><br>
                                        <span>จำนวน: ${cart[productId]}</span><br>
                                        <span>ราคารวม: ฿${totalItemPrice}</span>
                                    </div>`;
                                cartItemsList.appendChild(listItem);
                            }
                        }
                        totalPriceElement.innerText = totalPrice.toFixed(2); // แสดงยอดรวม
                    }
                });
                document.getElementById('closeReceiptButton').addEventListener('click', function() {
                    location.reload(); // รีเฟรชหน้าเว็บเมื่อกดปิด modal ใบเสร็จ
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
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
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
                                        // ปิด modal หลังจากกดยืนยัน
                                        const cartModal = document.getElementById('cartModal');
                                        const modalInstance = bootstrap.Modal.getInstance(cartModal);
                                        modalInstance.hide();

                                        // Populate receipt details
                                        document.getElementById("receiptDate").innerText = new Date().toLocaleDateString();
                                        document.getElementById("customerName").innerText =@json($user->username);
                                        document.getElementById("customerAddress").innerText = @json($user->address); // Add this line for address

                                        const receiptItemsList = document.getElementById("receiptItemsList");
                                        receiptItemsList.innerHTML = ''; // Clear previous items

                                        items.forEach(item => {
                                            const listItem = document.createElement('li');
                                            listItem.innerText =
                                                `${item.name} (จำนวน: ${item.quantity} ราคาต่อหน่วย: ${item.price} บาท) ราคารวม: ${item.total} บาท`;
                                            receiptItemsList.appendChild(listItem);
                                        });

                                        document.getElementById("overallTotalReceipt").innerText = overallTotal + ' บาท';

                                        // Show the receipt modal
                                        const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
                                        receiptModal.show();
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
