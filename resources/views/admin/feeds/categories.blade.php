@extends('admin.layout')

@section('content')
    <div class="row">
        @include('admin.feeds._nav', ['shop' => $shop])
    </div>

    <div class="row">
        <div class="col">
            @if($categories->isNotEmpty())

                @component('components.tree', ['items'=> $categories, 'id' => 'categories'])
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
