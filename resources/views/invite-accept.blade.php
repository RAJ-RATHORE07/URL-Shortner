<!DOCTYPE html>
<html>
<head>
    <title>Accept Invitation</title>
</head>
<body>
<h1>Accept Invitation ({{ $invitation->role }})</h1>

<form method="POST" action="{{ route('invite.accept.submit', $invitation->token) }}">
    @csrf
    <p>Email: {{ $invitation->email }}</p>

    <p>
        <label>Name:</label>
        <input type="text" name="name">
    </p>

    <p>
        <label>Password:</label>
        <input type="password" name="password">
    </p>

    <p>
        <label>Confirm Password:</label>
        <input type="password" name="password_confirmation">
    </p>

    <button type="submit">Create Account</button>
</form>

</body>
</html>
