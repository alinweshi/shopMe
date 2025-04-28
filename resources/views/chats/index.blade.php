<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>users</title>
</head>

<body>
    <h1>Users</h1>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</>
                <td>{{ $user ->fullName() }}</>
                <td>{{$user->isOnline()? 'online':'offline'}}    
                <td><a href="{{ route('chat', $user->id) }}">Chat</a></td>
            </tr>
            @endForeach

        </tbody>
</body>

</html>