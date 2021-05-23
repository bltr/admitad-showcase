@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-lowercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shops</li>
                </ol>
            </nav>

            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Site</th>
                    <th>Feed</th>
                </tr>
                @foreach($shops as $shop)
                    <tr>
                        <th>{{ $shop->id }}</th>
                        <td>{{ $shop->name }}</td>
                        <td><a href="{{ $shop->site }}" target="_blank">{{ $shop->site }}</a></td>
                        <td><a href="{{ route('admin.shops.feeds.offers', $shop) }}">feed</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
