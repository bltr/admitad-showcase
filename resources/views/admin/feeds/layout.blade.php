@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            @include('admin.feeds.components._breadcrums', ['shop' => $currentShop ?? null])
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            <div class="list-group">
                @foreach($shops as $shop)
                    <a class="list-group-item text-secondary @if($shop->id === ($currentShop->id ?? null)) active @endif"
                       href="{{ route('admin.feeds.analytics', $shop) }}"
                       style="height: 3rem"
                    >
                        {{ $shop->id }}. {{ $shop->name }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-10">
            @yield('feed-content')
        </div>
    </div>
@endsection
