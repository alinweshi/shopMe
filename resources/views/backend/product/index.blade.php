<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
</head>

<body>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Product Id</th>
                <th>Product Name</th>
                <th>Product Category</th>
                <th>Product Description</th>
                <th>Product Price</th>
                <th>Product discount</th>
                <th>Product Final Price</th>
                <th>Product Images</th>
                <th>Product Attributes</th>
                <th>addToCart</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>
                    @if($product->categories->isNotEmpty())
                    @foreach ($product->categories as $category)
                    {{ $category->name}}@if(!$loop->last)/ @endif
                    @endforeach
                    @else
                    No Category
                    @endif
                </td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->discount_type }}</td>
                <td>@if ($product->discount)
                    <p>Discounted Price: ${{ $product->final_price }}</p>
                    @else
                    <p>Final Price: ${{ $product->price }}</p>
                    @endif
                </td>
                <td>
                    {{ $product->image }}
                </td>
                <td>
                    @if($product->productAttributes->isNotEmpty())
                    <ul>
                        @foreach ($product->productAttributes as $variant)
                        <li>
                            SKU: {{ $variant->sku }},
                            Price: ${{ number_format($variant->price, 2) }},
                            Stock: {{ $variant->stock }},
                            <!-- Display attributes for each variant -->
                            @if($variant->attributeValue)
                            Attributes:
                            <ul>
                                <li>{{ $variant->attribute->name }}: {{ $variant->attributeValue->value }}</li>
                            </ul>
                            @else
                            No Attributes
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @else
                    No Variants
                    @endif
                </td>
                <td>
                    <form action="{{ route('cart.add',$product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit">Add to Cart</button>
                    </form>


                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
