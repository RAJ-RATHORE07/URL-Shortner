<!DOCTYPE html>
<html>
<head>
    <title>Create Short URL</title>
</head>
<body>
<h1>Create Short URL</h1>

@if($errors->any())
    <div>
        @foreach($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('urls.store') }}">
    @csrf
    <label>Original URL:</label>
    <input type="text" name="original_url" value="{{ old('original_url') }}">
    <button type="submit">Create</button>
</form>

<p><a href="{{ route('dashboard') }}">Back to Dashboard</a></p>
</body>
</html>
