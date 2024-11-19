<tr>
    <td>
        <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="category-checkbox">
    </td>
    <td>{{ $category->id }}</td>
    <td style="{{ $level > 0 ? 'color: blue;' : '' }}">
        @if ($level === 0 && $category->children->isNotEmpty())
            <a data-bs-toggle="collapse" href="#collapseCategory{{ $category->id }}" role="button" aria-expanded="false" aria-controls="collapseCategory{{ $category->id }}">
                {{ $category->name }} <i class="ri-arrow-down-s-fill"></i>
            </a>
        @else
            {!! str_repeat('&nbsp;&nbsp;&nbsp;', $level) !!}{{ $level > 0 ? '--- ' : '' }}{{ $category->name }}
        @endif
    </td>
    <td>{{ $category->description }}</td>
     <td>
        @if($category->image) 
            <img src="{{ Storage::url($category->image) }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">
        @else
            <span>Không có ảnh</span>
        @endif
    </td>
    <td>
        <div class="dropdown">
            <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-2-fill"></i>
            </a>
             <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a href="{{ route('admin.categories.show', $category->id) }}" class="dropdown-item">View</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}">Edit</a></li>
                    <li>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                            @csrf
                            @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger">Xóa</button>
                          </form>
                    </li>
                </ul>
        </div>
    </td>
</tr>

<!-- Gọi đệ quy hiển thị danh mục con trong collapse -->
@if ($category->children->isNotEmpty())
    <tr class="collapse" id="collapseCategory{{ $category->id }}">
        <td colspan="6"> <!-- colspan 5 để phủ hết các cột -->
            <table class="table table-borderless">
                <tbody>
                    @foreach ($category->children as $childCategory)
                        @include('admin.categories.partials.category-row', ['category' => $childCategory, 'level' => $level + 1])
                    @endforeach
                </tbody>
            </table>
        </td>
    </tr>
@endif