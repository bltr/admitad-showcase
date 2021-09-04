@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-lowercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Feeds</li>
                </ol>
            </nav>

            <ul class="list-group">
                @foreach($shops as $shop)
                    <li class="list-group-item"><a href="{{ route('admin.feeds.offers', $shop) }}">{{ $shop->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
