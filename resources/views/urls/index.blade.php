<!DOCTYPE html>
<html>
<head>
    <title>URLs List</title>
</head>
<body>

<h1>Your URLs</h1>

<p><a href="{{ route('dashboard') }}">Back to Dashboard</a></p>

@if(session('status'))
    <p style="color: green;">{{ session('status') }}</p>
@endif

{{-- Only Admin + Member can create short URLs --}}
@if(auth()->user()->role !== 'superadmin')
    <p><a href="{{ route('urls.create') }}">Create new short URL</a></p>
@endif

@if($urls->count())
    <table border="1" cellpadding="5">
        <thead>
        <tr>
            <th>ID</th>
            <th>Original</th>
            <th>Short</th>
            <th>Company</th>
            <th>User</th>
        </tr>
        </thead>
        <tbody>
        @foreach($urls as $url)
            <tr>
                <td>{{ $url->id }}</td>
                <td>{{ $url->original_url }}</td>
                <td>
                    <a href="{{ url('/s/' . $url->short_code) }}" target="_blank">
                        {{ url('/s/' . $url->short_code) }}
                    </a>
                </td>
                <td>{{ $url->company->name ?? '-' }}</td>
                <td>{{ $url->user->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>No URLs found.</p>
@endif

</body>
</html>
