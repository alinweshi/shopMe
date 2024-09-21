<div>
    <!-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius -->
</div>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>discount-products</title>
</head>

<body>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <th>id</th>
            <th>discount name</th>
            <th>discount products</th>
        </thead>
        <tbody>
            @foreach ($discounts as $discount )
            <tr>
                <td>{{ $discount->id }}</td>
                <td>{{ $discount->name }}</td>
                <td>@if ($discount->products->isNotEmpty()){
                    @foreach ($discount->products as $category)
                    {{ $category->name }},
                    @endforeach
                    }
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>