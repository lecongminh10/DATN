<tr>
    <td>
        <div class="form-check">
            <input class="form-check-input category-checkbox" type="checkbox" name="categories[]" value="{{ $item->id }}" id="cardtableCheck{{ $item->id }}">
            <label class="form-check-label" for="cardtableCheck{{ $item->id }}"></label>
        </div>
    </td>
    <td>{{ $level === 0 ? $key + 1 : '' }}</td>
    <td>{{ str_repeat('--- ', $level) }}{{ $item->name }}</td>
    <td>{{ $item->description }}</td>
    <td class="text-center">
        <div style="width: 50px; height: 50px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
            <img src="{{ Storage::url($item->image) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="">
        </div>
    </td>
    <td>{{ $item->parent ? $item->parent->name : 'None' }}</td>
    <td>{!! $item->is_active ? '<span class="badge bg-success"> Hoạt động </span>' : '<span class="badge bg-danger"> Không hoạt động </span>' !!}</td>
    <td>
        <div class="dropdown">
            <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-2-fill"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a href="{{ route('admin.categories.show', $item->id) }}" class="dropdown-item">Xem</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.categories.edit', $item->id) }}">Sửa</a></li>
                <li>
                    <form class="dropdown-item" action="{{ route('admin.categories.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                        @csrf
                        @method('DELETE')
                        <button class="dropdown-item" type="submit">Xóa</button>
                    </form>
                </li>
            </ul>
        </div>
    </td>
</tr>

@if (!empty($item->children))
    @foreach ($item->children as $child)
        @include('admin.categories.partials.category_row', ['item' => $child, 'level' => $level + 1])
    @endforeach
@endif
