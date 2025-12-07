<!DOCTYPE html>
<html>
<head>
    <title>Accept Invitation</title>
</head>
<body>
<h1>Accept Invitation for {{ $invitation->role }} @ {{ $invitation->company->name ?? 'No Company' }}</h1>

@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('invitations.accept.post', $invitation->token) }}">
    @csrf
    <label>Name:</label>
    <input type="text" name="name" value="{{ old('name') }}"><br><br>

    <label>Password:</label>
    <input type="password" name="password"><br><br>

    <label>Confirm Password:</label>
    <input type="password" name="password_confirmation"><br><br>

    <button type="submit">Create Account</button>
</form>

</body>
</html>
