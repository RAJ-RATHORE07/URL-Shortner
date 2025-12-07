<!DOCTYPE html>
<html>
<head>
    <title>URL Shortener</title>
</head>
<body>
    @auth
        <p>
            Logged in as: {{ auth()->user()->name }} ({{ auth()->user()->role }})
            |
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </p>
    @endauth

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @yield('content')
</body>
</html>
