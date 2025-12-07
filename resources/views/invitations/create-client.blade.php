@extends('layouts.app')

@section('content')
<h1>Invite Client (SuperAdmin)</h1>

<form method="POST" action="{{ route('invite.client.store') }}">
    @csrf
    <div>
        <label>Client Admin Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        <label>New Company Name</label><br>
        <input type="text" name="company_name" value="{{ old('company_name') }}">
    </div>

    <button type="submit">Create Invitation</button>
</form>
@endsection
