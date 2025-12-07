<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h1>Dashboard</h1>

<p>
    Logged in as:
    <strong>{{ auth()->user()->name }}</strong>
    ({{ ucfirst(auth()->user()->role) }})
</p>

{{-- Show Company only if user has one --}}
@if(auth()->user()->company)
<p>
    Company: <strong>{{ auth()->user()->company->name }}</strong>
</p>
@endif

@if(session('status'))
    <p style="color: green;">{{ session('status') }}</p>
@endif

<hr>

{{-- SuperAdmin Actions --}}
@if(auth()->user()->role === 'superadmin')
    <h3>SuperAdmin Actions</h3>
    <p>
        <a href="{{ route('invite.admin') }}">➕ Invite Admin to new Company</a>
    </p>
@endif

{{-- Admin Actions --}}
@if(auth()->user()->role === 'admin')
    <h3>Admin Actions</h3>
    <p>
        <a href="{{ route('invite.member') }}">👤 Invite Member to your Company</a>
    </p>
@endif

{{-- Admin & Member: Create URL --}}
@if(auth()->user()->role !== 'superadmin')
    <h3>Create Short URL</h3>

    @if($errors->any())
        <ul style="color:red;">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('urls.store') }}">
        @csrf
        <input
            type="text"
            name="original_url"
            placeholder="https://example.com"
            style="width:300px;"
            value="{{ old('original_url') }}"
        >
        <button type="submit">Create</button>
    </form>
@endif

<hr>

<h3>Your URLs</h3>

@if($urls->count())
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Original</th>
            <th>Short</th>
            <th>Created By</th>
            <th>Company</th>
            <th>Role</th>
        </tr>

        @foreach($urls as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->original_url }}</td>
                <td>
                    <a href="/s/{{ $u->short_code }}" target="_blank">
                        {{ url('/s/'.$u->short_code) }}
                    </a>
                </td>
                <td>{{ $u->user->name }}</td>
                <td>{{ $u->user->company ? $u->user->company->name : 'N/A' }}</td>
                <td>{{ ucfirst($u->user->role) }}</td>

            </tr>
        @endforeach
    </table>
@else
    <p>No URLs yet.</p>
@endif

<br><br>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>

</body>
</html>
