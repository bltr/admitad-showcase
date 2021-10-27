@extends('admin.feeds.layout')

@section('feed-content')
    <div class="row">
        @include('admin.feeds.components._nav', ['shop' => $currentShop])
    </div>

    <div class="row">
        <div class="col">
            @if($categories->isNotEmpty())
                @include('components.tree', [
                    'items' => $categories,
                    'itemTemplate' => 'admin.feeds._categories-tree-item',
                    'id' => 'a'
                ])
            @else
                <div class="my-5 small text-secondary text-center">
                    Нет данных
                </div>
            @endif
        </div>
    </div>
@endsection
