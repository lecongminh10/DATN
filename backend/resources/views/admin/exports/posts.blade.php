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
        @foreach ($posts as $post)
            <tr>
                @foreach ($columns as $column)
                    <td>{{ $post->$column }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>