<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Category</title>
</head>

<body>
    <table border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>Category Name</th>
            <th>Category Products</th>
            <th>Category Slug</th>
            <th>Category Image</th>
            <th>Category Parent</th>
            <th>Category Description</th>
            <th>Category Created At</th>
            <th>Category Updated At</th>
        </tr>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <!-- Show the products of the category -->
            <td>
                @if($category->products->isEmpty())
                <p>No products in this category.</p>
                @else
                <ul>
                    @foreach ($category->products as $product)
                    <li>
                        <strong>{{ $product->name }}</strong> <br>
                        {{ $product->description }} <br>
                        Price: ${{ $product->price }} <br>
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                    </li>
                    @endforeach
                </ul>
                @endif
            </td>
            <td>{{ $category->slug }}</td>
            <td><img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="100"></td>
            <td>
                @if($category->parent)
                {{ $category->parent->name }}
                @else
                No Parent
                @endif
            </td>
            <td>{{ $category->description }}</td>


            <td>{{ $category->created_at }}</td>
            <td>{{ $category->updated_at }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>