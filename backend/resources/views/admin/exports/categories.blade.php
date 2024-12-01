<table>
    <thead>
        <tr>
            @foreach ($columns as $column)
                <!-- Sử dụng tiêu đề tiếng Việt cho mỗi cột đã chọn -->
                <th>{{ $headings[$column] ?? $column }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
            <tr>
                @foreach ($columns as $column)
                    <td>{{ $category->$column }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>