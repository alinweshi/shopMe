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
                <th>Product Final Price</th>
                <th>Product Images</th>
                <th>Product Attributes</th>
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
                <td>@if ($product->discounts->isNotEmpty())
                    <p>Discounted Price: ${{ $product->final_price }}</p>
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
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>