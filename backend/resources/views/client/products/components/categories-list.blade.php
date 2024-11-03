<ul class="cat-list">
    @foreach ($categories as $category)
        <li>
            <a href="{{ route('client.products.Category', ['id' => $category->id]) }}">
                {{ $category->name }}
                <span class="products-count">({{ $category->products_count }})</span>
            </a>
            
            {{-- Show toggle button only if the category has children --}}
            @if ($category->children->isNotEmpty())
                <span class="toggle" 
                      role="button"
                      aria-expanded="false"
                      aria-controls="category-{{ $category->id }}"
                      onclick="toggleDropdown(event)">
                </span>

                {{-- Subcategory list, initially hidden --}}
                <ul class="cat-sublist" id="category-{{ $category->id }}" style="display: none;">
                    @include('client.products.components.categories-list', ['categories' => $category->children])
                </ul>
            @endif
        </li>
    @endforeach
</ul>

