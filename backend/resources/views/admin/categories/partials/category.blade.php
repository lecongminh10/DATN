<div class="list-group-item nested-{{ $category->level }}" data-id="{{ $category->id }}">
    <input type="checkbox" 
           name="category_id" 
           value="{{ $category->id }}" 
           id="category-{{ $category->id }}" 
           class="category-checkbox"
           @if(isset($product) && $product->category_id == $category->id) checked @endif> <!-- Check if category_id matches -->
    <label for="category-{{ $category->id }}" class="form-check-label">{{ $category->name }}</label>
    
    @if($category->children->isNotEmpty())
        <div class="list-group nested-list nested-sortable">
            @foreach($category->children as $child)
                @include('admin.categories.partials.category', ['category' => $child])
            @endforeach
        </div>
    @endif
</div>
