@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            @include('admin.feeds.components._breadcrums', compact('shop'))

            @include('admin.feeds.components._nav', compact('shop'))
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-2">
            <ul class="list-group">
                @foreach($shops as $shop)
                    <li class="list-group-item">
                        <a href="{{ route(request()->route()->getName(), $shop) }}">{{ $shop->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-10">
            @yield('feed-content')
        </div>
    </div>
@endsection
