<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SuperAdmin Dashboard</title>
</head>
<body>
    <h1>SuperAdmin Dashboard</h1>

    <p>Welcome, {{ auth()->user()->name }} ({{ auth()->user()->role }})</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
