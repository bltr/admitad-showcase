@extends('admin.feeds.layout')

@section('feed-content')
    <div class="row">
        @include('admin.feeds.components._nav', ['shop' => $currentShop])
    </div>

    <div class="row">
        <div class="col">
            @if($categories->isNotEmpty())
                @component('components.tree', ['items'=> $categories, 'id' => 'a'])
                    @scopedSlot('itemTemplate', ($item))
                        <div>{{ $item->name }}</div>
                    @endScopedSlot
                @endcomponent
            @else
                <div class="my-5 small text-secondary text-center">
                    Нет данных
                </div>
            @endif
        </div>
    </div>
@endsection
