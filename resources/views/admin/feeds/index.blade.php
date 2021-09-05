@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-lowercase">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Фиды</li>
                </ol>
            </nav>

            <table class="table">
                @foreach($shops as $shop)
                    <tr>
                        <th>{{ $shop->id }}</th>
                        <td>{{ $shop->name }}</td>
                        <td><a href="{{ $shop->site }}" target="_blank">{{ $shop->site }}</a></td>
                        <td><a href="{{ route('admin.feeds.offers', $shop) }}">Офферы</a></td>
                        <td><a href="{{ route('admin.feeds.categories', $shop) }}">Категории</a></td>
                        <td><a href="{{ route('admin.feeds.analytics', $shop) }}">Аналитика</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
