@extends('admin.feeds.layout')

@section('feed-content')
    <div class="row">
        <div class="col">
            @include('admin.feeds.components._category-tree', compact('categories'))

            @if($categories->isEmpty())
                <div class="my-5 text-center">
                    Нет данных
                </div>
            @endif
        </div>
    </div>
@endsection
