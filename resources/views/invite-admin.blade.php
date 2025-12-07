<!DOCTYPE html>
<html>
<head>
    <title>Invite Admin</title>
</head>
<body>
<h1>Invite Admin (SuperAdmin only)</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('invite.admin.store') }}">
    @csrf
    <p>
        <label>Company Name:</label>
        <input type="text" name="company_name">
    </p>
    <p>
        <label>Admin Email:</label>
        <input type="email" name="email">
    </p>
    <button type="submit">Invite</button>
</form>

</body>
</html>
