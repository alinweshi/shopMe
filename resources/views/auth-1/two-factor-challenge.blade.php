<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Two Factor Authentication Challenge</title>
</head>

<body>
    <h1>Two Factor Authentication Challenge</h1>

    <!-- Display any errors (like an invalid code) -->
    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form to input the two-factor authentication code -->
    <form action="{{ route('two-factor.login') }}" method="post">
        @csrf
        <label for="code">Enter your authentication code:</label>
        <input type="text" name="code" id="code" required>

        <button type="submit">Submit</button>
    </form>
</body>

</html>