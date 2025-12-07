<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - URL Shortener</title>
</head>
<body>
    <h1>Login</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.perform') }}">
        @csrf

        <div>
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>

        <button type="submit">Login</button>
    </form>
</body>
</html>
