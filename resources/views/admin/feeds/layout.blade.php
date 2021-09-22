@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            @include('admin.feeds.components._breadcrums', ['shop' => $currentShop])

            @include('admin.feeds.components._nav', ['shop' => $currentShop])
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-2">
            <div class="list-group">
                @foreach($shops as $shop)
                    <a class="list-group-item @if($shop->is($currentShop)) active @endif" href="{{ route(request()->route()->getName(), $shop) }}">{{ $shop->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="col-10">
            @yield('feed-content')
        </div>
    </div>
@endsection
