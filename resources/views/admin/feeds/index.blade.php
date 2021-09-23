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
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-secondary small">Тип группировки</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach($shops as $shop)
                    <tr>
                        <th>{{ $shop->id }}</th>
                        <td><a href="{{ $shop->site }}" target="_blank">{{ $shop->name }}</a></td>
                        <td>
                            <form action="{{ route('admin.feeds.toggle-activity', $shop) }}" method="POST">
                                @method('patch')
                                @csrf

                                @if($shop->is_active)
                                    <button class="btn btn-warning btn-sm">Отключить импорт</button>
                                @else
                                    <button class="btn btn-danger btn-sm">Подключить импорт</button>
                                @endif
                            </form>
                        </td>
                        <td>{{ $shop->import_type }}</td>
                        <td><a href="{{ route('admin.feeds.offers', $shop) }}">Офферы</a></td>
                        <td><a href="{{ route('admin.feeds.categories', $shop) }}">Категории</a></td>
                        <td><a href="{{ route('admin.feeds.analytics', $shop) }}">Аналитика</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
