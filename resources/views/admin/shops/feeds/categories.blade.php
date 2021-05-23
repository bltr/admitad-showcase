@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-lowercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.shops.index') }}">Shops</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $shop->name }}</li>
                </ol>
            </nav>

            <div class="btn-group my-2">
                <a href="{{ route('admin.shops.feeds.offers', $shop->id) }}" class="btn btn-primary" aria-current="page">Offers</a>
                <a href="{{ route('admin.shops.feeds.categories', $shop->id) }}" class="btn btn-primary active">Categories</a>
                <a href="{{ route('admin.shops.feeds.analytics', $shop->id) }}" class="btn btn-primary">Analytics</a>
            </div>

            {!! $rendered_list !!}
        </div>
    </div>
@endsection
