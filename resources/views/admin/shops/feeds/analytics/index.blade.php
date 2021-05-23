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
                <a href="{{ route('admin.shops.feeds.categories', $shop->id) }}" class="btn btn-primary">Categories</a>
                <a href="{{ route('admin.shops.feeds.analytics', $shop->id) }}" class="btn btn-primary active">Analytics</a>
            </div>

            @if ($analytics)
                <h5 class="my-4">{{ $analytics->created_at }}</h5>

                {!! $report->render() !!}
            @else
                <p class="my-5 text-center">Нет подготовленных данных</p>
            @endif

        </div>
    </div>
@endsection
