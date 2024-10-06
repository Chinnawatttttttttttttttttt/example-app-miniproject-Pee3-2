<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>

    <form action="{{ route('register.user') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" required>
            <span class="text-danger">
                @error('username')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>
            <span class="text-danger">
                @error('email')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="from-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>
            <span class="text-danger">
                @error('password')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Register</button>
        <button><a href="{{ route('login') }}">Back</a></button>
    </form>

</body>
</html>
