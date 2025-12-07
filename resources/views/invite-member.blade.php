<!DOCTYPE html>
<html>
<head>
    <title>Invite User</title>
</head>
<body>
<h1>Invite Admin/Member (Admin only)</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('invite.member.store') }}">
    @csrf
    <p>
        <label>Email:</label>
        <input type="email" name="email">
    </p>
    <p>
        <label>Role:</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="member">Member</option>
        </select>
    </p>
    <button type="submit">Invite</button>
</form>

</body>
</html>
