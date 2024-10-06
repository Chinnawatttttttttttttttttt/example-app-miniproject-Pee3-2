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
    <title> Home </title>
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
            <div class="content">
                <div class="row">
                    @foreach ($products as $item)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <!-- Display product image from the database with fixed size -->
                                                <img src="{{ url('/' . $item->image) }}" alt="{{ $item->name }}"
                                                    class="img-fluid fixed-img"
                                                    style="max-width: 100px; height: 100px; object-fit: cover;">
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <h7 class="card-title" style="margin:0;">{{ $item->name }}</h7>
                                                <p class="card-text" style="font-size:20px; font-weight: bold;">ราคา:
                                                    {{ $item->price }}</p>
                                                <div class="quantity-controls">
                                                    <button class="decrease-quantity"
                                                        onclick="changeQuantity('{{ $item->id }}', -1)">-</button>
                                                    <span id="quantity-{{ $item->id }}">0</span>
                                                    <button class="increase-quantity"
                                                        onclick="changeQuantity('{{ $item->id }}', 1)">+</button>
                                                </div>
                                                <button onclick="addToCart('{{ $item->id }}', '{{ $item->name }}')">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button id="showCartButton" onclick="toggleCartItems()">แสดงสินค้าที่เพิ่มลงในตะกร้า</button>
            <!-- Cart items modal or section -->
            <div id="cartItemsModal" style="display: none; padding: 10px; border: 1px solid #ccc;">
                <h3>สินค้าที่อยู่ในตะกร้า</h3>
                <ul id="cartItemsList"></ul>
                <button id="submitDataButton">ยืนยันการสั่งซื้อ</button>
            </div>
            <script>
                const cart = {};
            
                function toggleCartItems() {
                    const cartItemsModal = document.getElementById("cartItemsModal");
                    const cartItemsList = document.getElementById("cartItemsList");
                    const showCartButton = document.getElementById("showCartButton");
            
                    if (cartItemsModal.style.display === 'none') {
                        // Clear previous items
                        cartItemsList.innerHTML = '';
            
                        // Check if there are items in the cart
                        if (Object.keys(cart).length === 0) {
                            cartItemsList.innerText = 'ยังไม่มีสินค้าที่เพิ่มลงในตะกร้า'; // Message when cart is empty
                        } else {
                            // Loop through each item in the cart
                            for (const productId in cart) {
                                const product = @json($products).find(item => item.id == productId); // Find the product by ID
            
                                // Only display items with quantity greater than 0
                                if (product && cart[productId] > 0) {
                                    const listItem = document.createElement('li');
                                    // Display product name and quantity
                                    listItem.innerText = `ชื่อสินค้า: ${product.name}, จำนวน: ${cart[productId]}`;
            
                                    // Create a remove button
                                    const removeButton = document.createElement('button');
                                    removeButton.innerText = 'ลบ';
                                    removeButton.onclick = () => removeFromCart(productId);
                                    listItem.appendChild(removeButton);
            
                                    cartItemsList.appendChild(listItem);
                                }
                            }
                        }
                        cartItemsModal.style.display = 'block';
                        showCartButton.innerText = 'ซ่อนสินค้าที่เพิ่มลงในตะกร้า';
                    } else {
                        // If modal is visible, hide the cart items
                        cartItemsModal.style.display = 'none';
                        showCartButton.innerText = 'แสดงสินค้าที่เพิ่มลงในตะกร้า';
                    }
                }
            
                function changeQuantity(productId, change) {
                    const quantitySpan = document.getElementById(`quantity-${productId}`);
                    let quantity = parseInt(quantitySpan.innerText);
                    quantity += change;
            
                    // Ensure quantity does not go below zero
                    if (quantity < 0) {
                        quantity = 0;
                    }
            
                    // Update the displayed quantity
                    quantitySpan.innerText = quantity;
            
                    // Update the cart if quantity is zero
                    if (quantity === 0) {
                        delete cart[productId]; // Remove product from cart
                    } else {
                        cart[productId] = quantity; // Update quantity in cart
                    }
                }
            
                function addToCart(productId, name) {
                    const quantitySpan = document.getElementById(`quantity-${productId}`);
                    const quantity = parseInt(quantitySpan.innerText);
            
                    // Only add to the cart if quantity is greater than 0
                    if (quantity > 0) {
                        cart[productId] = quantity; // Set quantity directly in cart
                        alert(`เพิ่ม ${name} จำนวน ${quantity} ไปยังตะกร้า!`);
            
                        // Hide the cart items modal after adding items to the cart
                        const cartItemsModal = document.getElementById("cartItemsModal");
                        cartItemsModal.style.display = 'none';
                        document.getElementById("showCartButton").innerText = 'แสดงสินค้าที่เพิ่มลงในตะกร้า';
                    } else {
                        // Show alert if quantity is 0
                        alert("กรุณาเพิ่มจำนวนสินค้าก่อนเพิ่มลงตะกร้า!");
                    }
            
                    // Update the button text based on cart content
                    updateCartButton();
                }
            
                function showCartItems() {
                    const cartItemsList = document.getElementById("cartItemsList");
                    cartItemsList.innerHTML = ''; // Clear previous items
            
                    // Check if there are items in the cart
                    if (Object.keys(cart).length === 0) {
                        cartItemsList.innerText = 'ยังไม่มีสินค้าที่เพิ่มลงในตะกร้า'; // Message when cart is empty
                    } else {
                        // Loop through each item in the cart
                        for (const productId in cart) {
                            const product = @json($products).find(item => item.id == productId); // Find the product by ID
            
                            // Only display items with quantity greater than 0
                            if (product && cart[productId] > 0) {
                                const listItem = document.createElement('li');
                                // Display product name and quantity
                                listItem.innerText = `ชื่อสินค้า: ${product.name}, จำนวน: ${cart[productId]}`;
            
                                // Create a remove button
                                const removeButton = document.createElement('button');
                                removeButton.innerText = 'ลบ';
                                removeButton.onclick = () => removeFromCart(productId);
                                listItem.appendChild(removeButton);
            
                                cartItemsList.appendChild(listItem);
                            }
                        }
                    }
            
                    // Show the modal
                    document.getElementById("cartItemsModal").style.display = 'block';
                }
            
                function removeFromCart(productId) {
                    // Remove the product from the cart
                    delete cart[productId];
            
                    // Update the cart display
                    showCartItems();
                    
                    // Update the button text based on cart content
                    updateCartButton();
                }
            
                function updateCartButton() {
                    const showCartButton = document.getElementById("showCartButton");
                    // Show the button regardless of cart state
                    showCartButton.style.display = 'block';
                    if (Object.keys(cart).length === 0) {
                        showCartButton.innerText = 'เพิ่มสินค้าลงในตะกร้า'; // Text when cart is empty
                    } else {
                        showCartButton.innerText = 'แสดงสินค้าที่เพิ่มลงในตะกร้า'; // Text when there are items
                    }
                }
            </script>
            
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <!-- Button for confirming purchase -->
            <!-- Bootstrap Modal for Receipt -->
            <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="receiptModalLabel">ใบเสร็จ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>วัน: <span id="receiptDate"></span></p>
                            <p>ชื่อผู้สั่ง: <span id="customerName"></span></p>
                            <h3>รายการสินค้า:</h3>
                            <ul id="receiptItemsList"></ul>
                            <p>รวมทั้งหมด: <span id="overallTotalReceipt"></span> บาท</p>
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
                                        listItem.innerText = `${item.name} (จำนวน: ${item.quantity}, ราคา: ${item.price} บาท) ราคารวม: ${item.total} บาท`;
                                        receiptItemsList.appendChild(listItem);
                                    });
            
                                    document.getElementById("overallTotalReceipt").innerText = overallTotal + ' บาท';
            
                                    // Show the modal
                                    const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
                                    receiptModal.show();
                                    
                                    // Wait for the modal to be fully shown before downloading
                                    document.getElementById('downloadReceiptButton').onclick = function() {
                                        // Ensure the modal is fully visible
                                        setTimeout(() => {
                                            html2canvas(document.getElementById('receiptModal'))
                                                .then(canvas => {
                                                    const link = document.createElement('a');
                                                    link.download = 'ใบเสร็จ.png';
                                                    link.href = canvas.toDataURL('image/png');
                                                    link.click();
                                                });
                                        }, 500); // Delay to ensure the modal is rendered
                                    };
                                }
                            });
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                });
            
                // Refresh the page when the modal is closed
                document.getElementById('receiptModal').addEventListener('hidden.bs.modal', function() {
                    location.reload();
                });
            </script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.0.0-alpha.12/html2canvas.min.js"></script>
            
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
