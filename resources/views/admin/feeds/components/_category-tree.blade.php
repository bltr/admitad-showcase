<ul class="{{ ($is_not_first_level ?? false) ? 'border-start border-primary' : ''}}">
    @foreach($categories as $category)
        <li>
            {{ $category->data->value }}
            @if($category->children->isNotEmpty())
                @include('admin.feeds.components._category-tree', ['categories' => $category->children, 'is_not_first_level' => true])
            @endif
        </li>
    @endforeach
</ul>
