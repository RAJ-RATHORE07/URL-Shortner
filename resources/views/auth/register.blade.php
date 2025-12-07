@extends('layouts.app')

@section('content')
<h1>Register</h1>

<form method="POST" action="{{ url('/register') }}">
    @csrf

    <div>
        <label>Name</label><br>
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        <label>Password</label><br>
        <input type="password" name="password">
    </div>

    <div>
        <label>Confirm Password</label><br>
        <input type="password" name="password_confirmation">
    </div>

    <button type="submit">Register</button>
</form>
@endsection
