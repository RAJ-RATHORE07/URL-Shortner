@extends('layouts.app')

@section('content')
<h1>Invite Team Member (Admin)</h1>

<p>Company: {{ $user->company->name ?? '-' }}</p>

<form method="POST" action="{{ route('invite.team.store') }}">
    @csrf

    <div>
        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        <label>Role</label><br>
        <select name="role">
            <option value="">-- Select Role --</option>
            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
            <option value="Member" {{ old('role') == 'Member' ? 'selected' : '' }}>Member</option>
        </select>
    </div>

    <button type="submit">Create Invitation</button>
</form>
@endsection
