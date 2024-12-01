{{-- Table for Products --}}
<h3>Danh sách sản phẩm</h3>
<table>
    <thead>
        <tr>
            @foreach($headings['product_headings'] as $heading)
                <th>{{ $heading }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                @foreach($headings['product_headings'] as $column)
                    <td>
                        {{-- Display product data dynamically using column names --}}
                        {{ $product->$column }} <!-- Adjust if the column names need formatting -->
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Table for Product Variants --}}
<h3>Danh sách sản phẩm biến thể</h3>
<table>
    <thead>
        <tr>
            @foreach($headings['variant_headings'] as $heading)
                <th>{{ $heading }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($productVariants as $variant)
            <tr>
                @foreach($headings['variant_headings'] as $column)
                    <td>
                        {{-- Display product variant data dynamically using column names --}}
                        {{ $variant->$column }} <!-- Adjust if the column names need formatting -->
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
