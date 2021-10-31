@php $depth = $depth ?? 0; @endphp
@if($items->isNotEmpty())
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
                        {{ $itemTemplate($item) }}
                    @endif
                </div>

                @if($item->children->isNotEmpty())
                    @component('components.tree', [
                        'items'=> $item->children,
                        'itemTemplate' => $itemTemplate ?? null,
                        'id' => $id,
                        'parentItemId' => $item->id,
                        'depth' => $depth + 1,
                    ])@endcomponent
                @endif
            </li>
        @endforeach
    </ul>
@else
    <div class="small text-secondary text-center mt-5">Нет данных</div>
@endif
