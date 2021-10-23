@extends('admin.feeds.layout')

@section('feed-content')
    <div class="row">
        @include('admin.feeds.components._nav', ['shop' => $currentShop])
    </div>

    <div class="row">
        <div class="col">
            @if($categories->isNotEmpty())
                @include('admin.feeds.components._category-tree', compact('categories'))
            @else
                <div class="my-5 small text-secondary text-center">
                    Нет данных
                </div>
            @endif
        </div>
    </div>
@endsection
