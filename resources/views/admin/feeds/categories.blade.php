@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            @include('admin.feeds.components._breadcrums', compact('shop'))

            @include('admin.feeds.components._nav', compact('shop'))

            @include('admin.feeds.components._category-tree', compact('categories'))
        </div>
    </div>
@endsection
