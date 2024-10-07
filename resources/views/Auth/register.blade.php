<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ลงทะเบียน</title>
    <!-- เรียกใช้ไฟล์ CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/paper-dashboard.css') }}">

</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>ลงทะเบียน</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register.user') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="username">ชื่อผู้ใช้</label>
                                <input type="text" class="form-control" name="username" required>
                                <span class="text-danger">
                                    @error('username')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="email">อีเมล</label>
                                <input type="email" class="form-control" name="email" required>
                                <span class="text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="password">รหัสผ่าน</label>
                                <input type="password" class="form-control" name="password" required>
                                <span class="text-danger">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="address">ที่อยู่</label>
                                <input type="text" class="form-control" name="address" required>
                                <span class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">ลงทะเบียน</button>
                            <a href="{{ route('login') }}" class="btn btn-secondary btn-block">กลับไปยังหน้าเข้าสู่ระบบ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
