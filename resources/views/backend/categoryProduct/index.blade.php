<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>categoryProduct</title>
</head>

<body>
    <table>
        <tr>
            <th>id</th>
            <th>caregoty name</th>
            <th>product name</th>

        </tr>
        @foreach ($categoryProducts as $categoryProduct)
        <tr>
            <td>{{$categoryProduct->id}}</td>
            <td>{{$categoryProduct->category->name}}</td>
            <td>{{$categoryProduct->product->name}}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>