@php $depth = $depth ?? 0; @endphp
<ul class="{{ !$depth ? 'tree' : '' }} {{ $depth ? 'collapse' : '' }}"
    @if($depth) id="{{ $id }}-collapse-{{ $parentItemId }}" @endif
>
    @foreach($items as $item)
        <li data-item-id="{{ $item->id }}">
            <div class="tree_node">
                <div class="tree_node_toggle">
                    @if($item->children->isNotEmpty())
                        <button type="button" class="btn" data-bs-toggle="collapse" data-bs-target="#{{ $id }}-collapse-{{ $item->id }}">
                            <i class="bi bi-plus"></i>
                        </button>
                    @else
                        <button type="button" class="btn disabled">
                            <i class="bi bi-dot"></i>
                        </button>
                    @endif
                </div>

                @if(!empty($itemTemplate))
                    @include($itemTemplate)
                @endif
            </div>

            @if($item->children->isNotEmpty())
                @include('components.tree', [
                    'items' => $item->children,
                    'itemTemplate' => $itemTemplate,
                    'id' => $id,
                    'parentItemId' => $item->id,
                    'depth' => $depth + 1,
                ])
            @endif
        </li>
    @endforeach
</ul>
