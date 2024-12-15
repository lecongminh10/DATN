
@php
$indentation = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level); // Thêm khoảng cách dựa trên cấp độ
@endphp
<tr class="{{ $level > 0 ? 'collapse' : '' }}" id="{{ $level > 0 ? 'child-' . $parentId : '' }}">
<td scope="col">
    <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="category-checkbox">
</td>
<td scope="col">{{ $loop->iteration }}</td>
<td scope="col">
    {!! $indentation !!}
    {{ $category->name }}
    @if ($category->children->isNotEmpty())
        <span class="toggle-subcategories" data-bs-toggle="collapse" data-bs-target="#child-{{ $category->id }}" aria-expanded="false" aria-controls="child-{{ $category->id }}">
            <i class="ri-arrow-right-s-fill"></i>
        </span>
    @endif
</td>
<td scope="col">
    @php
        $words = explode(' ', $category->description);
    @endphp

    @if(count($words) > 7)
        {{ implode(' ', array_slice($words, 0, 7)) }}...
    @else
        {{ $category->description }}
    @endif
</td>
<td scope="col" class="text-center align-middle" style="width:70px ; font-size:13px">
    @if ($category->is_active == 1)
        <span class="badge text-bg-success">Kích hoạt</span>
    @else
        <span class="badge text-bg-danger">Không kích hoạt</span>
    @endif
</td>
<td scope="col">
    @if ($category->image)
        <img src="{{ Storage::url($category->image) }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">
    @else
        <span>Không có ảnh</span>
    @endif
</td>
<td scope="col">
    <div class="dropdown">
        <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ri-more-2-fill"></i>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{ route('admin.categories.show', $category->id) }}" class="dropdown-item">Xem</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}">Sửa</a></li>
            <li>
                <button 
                    type="button" 
                    class="dropdown-item text-danger delete-category-button" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteCategoryModal" 
                    data-category-id="{{ $category->id }}">
                    Xóa
                </button>
            </li>        
        </ul>
    </div>
</td>
</tr>

@if ($category->children->isNotEmpty())
@foreach ($category->children as $child)
    @include('admin.categories.partials.category-row', [
        'category' => $child,
        'level' => $level + 1,
        'parentId' => $category->id,
    ])
@endforeach
@endif
    
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Xóa Danh Mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa danh mục này?
                <form id="delete-category-form" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-category">Xóa</button>
            </div>
        </div>
    </div>
</div>
