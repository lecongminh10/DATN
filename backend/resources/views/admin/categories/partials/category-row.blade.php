
    <tr>
        <td scope="col">
            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="category-checkbox">
        </td>
        <td scope="col">{{ $loop->iteration }}</td>
        <td scope="col">
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
        <td scope="col" class="text-center align-middle">
            @if($category->is_active)
                <i class="ri-checkbox-circle-fill text-success" style="font-size: 24px;"></i> 
            @else
                <i class="ri-checkbox-blank-circle-fill text-danger" style="font-size: 24px;"></i> 
            @endif
        </td>              
        <td scope="col">
            @if ($category->image)
                <img src="{{ Storage::url($category->image) }}" alt="{{$category->image}}" style="width: 50px; height: 50px; object-fit: cover;">
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
                    <li><a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}">Cập nhật</a></li>
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

    @if ($category->children->isNotEmpty())
        @foreach ($category->children as $childCategory)
            @php
                $childIndex = $loop->parent->iteration . '.' . $loop->iteration; // Định dạng số thứ tự của danh mục con
            @endphp
            <tr class="collapse" id="child-{{ $category->id }}">
                <td scope="col">
                    <input type="checkbox" name="category_ids[]" value="{{ $childCategory->id }}" class="category-checkbox">
                </td>
                <td scope="col">{{ $childIndex }}</td>
                <td scope="col">
                    <span class="child-prefix">&nbsp;&nbsp;&nbsp;&nbsp;---</span> <!-- Thêm dấu cách cho danh mục con -->
                    <span class="child-name">{{ $childCategory->name }}</span>
                    @if ($childCategory->children->isNotEmpty())
                        <span class="toggle-subcategories" data-bs-toggle="collapse" data-bs-target="#sub-child-{{ $childCategory->id }}" aria-expanded="false" aria-controls="sub-child-{{ $childCategory->id }}">
                            <i class="ri-arrow-right-s-fill"></i>
                        </span>
                    @endif
                </td>
                <td scope="col">
                    @php
                        $words = explode(' ', $childCategory->description);
                    @endphp
                
                    @if(count($words) > 7)
                        {{ implode(' ', array_slice($words, 0, 7)) }}...
                    @else
                        {{ $childCategory->description }}
                    @endif
                </td>  
                <td scope="col" class="text-center align-middle">
                    @if($childCategory->is_active)
                        <i class="ri-checkbox-circle-fill text-success" style="font-size: 24px;"></i> 
                    @else
                        <i class="ri-checkbox-blank-circle-fill text-danger" style="font-size: 24px;"></i> 
                    @endif
                </td>                                   
                <td scope="col">
                    @if ($childCategory->image)
                        <img src="{{ Storage::url($childCategory->image) }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">
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
                            <li><a href="{{ route('admin.categories.show', $childCategory->id) }}" class="dropdown-item">View</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.categories.edit', $childCategory->id) }}">Edit</a></li>
                            <li>
                                <form action="{{ route('admin.categories.destroy', $childCategory->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">Xóa</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>

            @if ($childCategory->children->isNotEmpty())
                @foreach ($childCategory->children as $subChildCategory)
                    @php
                        $subChildIndex = $childIndex . '.' . $loop->iteration; // Định dạng số thứ tự cho danh mục con cấp sâu
                    @endphp
                    <tr class="collapse" id="sub-child-{{ $childCategory->id }}">
                        <td scope="col">
                            <input type="checkbox" name="category_ids[]" value="{{ $subChildCategory->id }}" class="category-checkbox">
                        </td>
                        <td scope="col">{{ $subChildIndex }}</td>
                        <td scope="col">
                            <span class="child-prefix">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----</span> <!-- Thêm dấu cách cho danh mục con cấp sâu -->
                            <span class="subchild-name">{{ $subChildCategory->name }}</span>
                        </td>
                        <td scope="col">{{ $subChildCategory->description }}</td>
                        <td scope="col">
                            @if ($subChildCategory->image)
                                <img src="{{ Storage::url($subChildCategory->image) }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">
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
                                    <li><a href="{{ route('admin.categories.show', $subChildCategory->id) }}" class="dropdown-item">View</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.categories.edit', $subChildCategory->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('admin.categories.destroy', $subChildCategory->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Xóa</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    @endif